<?php

namespace App\Http\Controllers;

use App\News;
use App\NewsCat;
use Illuminate\Http\Request;

class NewsController extends AdminController
{
    private $headers = [

        'main' => [
            'news.id' => 'شناسه',
            'news.title' => 'عنوان',
            'news.description' => 'توضیحات',
            'news.position' => 'موقعیت',
            'news.display' => 'نمایش',
            'news_cats.title' => 'گروه',
        ],

        'actions' => [
            'quick_edit' => 'ویرایش سریع',
            'edit' => 'ویرایش',
            'delete' => 'حذف',
        ]

    ];

    private $tableName = 'news';

    public function datatable(Request $request)
    {
        $data = $this->Datatable->buildDatatable(
            $request->all(),
            new News(),
            $this->tableName,
            [
                [
                    'joinType' => 'OneToMany',
                    'table' => 'news_cats',
                    'foreignKey' => 'news_cat_id',
                ]
            ],
            null,
            $this->headers['main']
        );

        $data['headers'] = $this->headers;
        $data['table'] = $this->tableName;

        return response()->json($data, 206);
    }

    public function create()
    {
        $allNewsCat = NewsCat::select(['id', 'title'])->get()->toArray();

        $data['cats'] = $allNewsCat;

        return $data;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'news_cat_id' => 'required',
            'description' => 'nullable',
            'content' => 'nullable',
            'position' => 'nullable',
            'display' => 'nullable',
        ]);

        $newsCat = NewsCat::find($request->all()['news_cat_id']);

        $newsCat->news()->create($validatedData);

        $this->messages[] = [
            'message' => 'خبر جدید با موفقیت ایجاد شد.',
            'type' => 'success',
            'timeout' => 5000
        ];
        $data['messages'] = $this->messages;

        return $data;
    }

    public function edit(News $news)
    {
        $allNewsCat = NewsCat::select(['id', 'title'])->get()->toArray();
        $data['cats'] = $allNewsCat;
        $data['fields'] = $news->toArray();

        return $data;
    }

    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'news_cat_id' => 'required',
            'description' => 'nullable',
            'content' => 'nullable',
            'position' => 'nullable',
            'display' => 'nullable',
        ]);

//        return $validatedData;

        $newsCat = NewsCat::find($request->all()['news_cat_id']);
        $news->newsCat()->associate($newsCat);
        $news->update($validatedData);

        $this->messages[] = [
            'message' => 'خبر با موفقیت ویرایش شد.',
            'type' => 'success',
            'timeout' => 5000
        ];
        $data['messages'] = $this->messages;

        return $data;
    }

    public function delete(News $news)
    {
        if ($news && $news->id) {
            $this->messages[] = [
                'message' => 'خبر با آیدی ' . $news->id . ' با موفقیت حذف شد.',
                'type' => 'success',
                'timeout' => 5000
            ];
        } else {
            abort(404);
        }

        $data['messages'] = $this->messages;

        if ($news->delete() === true) {
            return response()->json($data, 200);
        } else {
            abort(500);
        }
    }
}
