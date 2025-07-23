<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use Illuminate\Http\Request;
use App\Services\InstagramService;

class ScheduledPostController extends Controller
{
    public function index(Request $request)
    {
        $query = ScheduledPost::query();

        if ($request->filled('product_name')) {
            $query->where('product_name', 'like', '%' . $request->product_name . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'posted') {
                $query->where('posted', true);
            } elseif ($request->status === 'pending') {
                $query->where('posted', false);
            }
        }

        if ($request->filled('date_start')) {
            $query->whereDate('created_at', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', floatval($request->price_min));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', floatval($request->price_max));
        }

        if ($request->filled('external_product_id')) {
            $query->where('external_product_id', $request->external_product_id);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        return view('admin.scheduled-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.scheduled-posts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateScheduledPost($request, false);
        ScheduledPost::create($data);

        return redirect()->route('admin.scheduled-posts.index')->with('success', 'Post agendado com sucesso.');
    }

    public function edit(ScheduledPost $scheduledPost)
    {
        return view('admin.scheduled-posts.edit', compact('scheduledPost'));
    }

    public function update(Request $request, ScheduledPost $scheduledPost)
    {
        $data = $this->validateScheduledPost($request, true);
        $scheduledPost->update($data);

        return redirect()->route('admin.scheduled-posts.index')->with('success', 'Post atualizado com sucesso.');
    }

    public function postNow(ScheduledPost $scheduledPost, InstagramService $instagram)
    {
        if ($scheduledPost->posted) {
            return back()->with('success', 'Esse post já foi publicado.');
        }

        $result = $instagram->uploadImageAndPublish($scheduledPost->image_url, $scheduledPost->caption);

        if ($result && isset($result['id'])) {
            $scheduledPost->posted = true;
            $scheduledPost->posted_at = now();
            $scheduledPost->save();

            return back()->with('success', 'Post publicado manualmente!');
        }

        return back()->with('error', 'Erro ao publicar no Instagram.');
    }

    public function destroy(ScheduledPost $scheduledPost)
    {
        $scheduledPost->delete();
        return redirect()->route('admin.scheduled-posts.index')->with('success', 'Post excluído.');
    }

    private function validateScheduledPost(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|url',
            'caption' => 'required|string',
            'scheduled_at' => $isUpdate ? 'nullable|date' : 'required|date',
            'price' => 'nullable|numeric',
            'posted' => 'boolean',
            'posted_at' => 'nullable|date',
        ]);
    }
}
