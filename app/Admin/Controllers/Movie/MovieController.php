<?php

namespace App\Admin\Controllers\Movie;

use App\Admin\Selectables\CastSelectable;
use App\Models\Movie\Movie;
use App\Models\Movie\MovieCategory;
use App\Models\Movie\MovieGenre;
use App\Models\Movie\MovieLanguage;
use App\Models\Movie\MovieNation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MovieController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Movie';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Movie());
        $grid->model()->withCount('episodes');

        $grid->column('id', __('Id'))->hide()->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('description', __('Description'))->hide();
        $grid->column('genres', __('Genres'))->pluck('name')->label();
        $grid->column('casts', __('Casts'))->pluck('name')->label('info');
        $grid->column('image', __('Cover'))->image()->hide();
        $grid->column('episodes_count', __('Episodes'))->sortable();
        $grid->column('category.name', __('Category'))->hide()->searchable();
        $grid->column('language.name', __('Language'))->searchable();
        $grid->column('nation.name', __('Nation'))->hide()->searchable();
        $grid->column('updated_at', __('Updated at'))->hide()->sortable();
        $grid->column('created_at', __('Created at'))->hide()->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', __('Name'));
            $filter->between('updated_at', __('Updated At'))->date();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $detail = Movie::findOrFail($id);
        $show = new Show($detail);

        $show->field('id', __('Id'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'))->image();
        $show->field('release_date', __('Release date'));
        $show->field('length', __('Length'));
        $show->field('number_of_episodes', __('Number of Eps'))->as(function ($numberOfEps) use ($detail) {
            return $numberOfEps . '/' . ($detail->total_episodes ?? '???');
        });

        $show->field('nation.name', __('Nation'));
        $show->field('language.name', __('Language'));
        $show->field('category.name', __('Category'));

        $show->episodes('Episodes', function (Grid $episodes) {
            $episodes->resource('/admin/movies/episodes');

            $episodes->id()->hide();
            $episodes->number()->sortable()->searchable();
            $episodes->quality()->sortable()->searchable();
            $episodes->name()->hide();
            $episodes->updated_at()->sortable();

            $episodes->disableFilter();
        });

        $show->trailers('Trailers', function (Grid $episodes) {
            $episodes->resource('/admin/movies/trailers');

            $episodes->id()->hide();
            $episodes->number()->sortable()->searchable();
            $episodes->quality()->sortable()->searchable();
            $episodes->updated_at()->sortable();

            $episodes->disableFilter();
        });

        $show->casts('Casts', function (Grid $casts) {
            $casts->resource('/admin/casts');

            $casts->id()->hide();
            $casts->name();
            $casts->updated_at()->sortable();

            $casts->disableBatchActions();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Movie());

        $form->text('name', __('Name'))->required();
        $form->textarea('description', __('Description'));
        $form->cropper('image', __('Image'))->cRatio(380, 500)->crop(380, 500);
        $form->date('release_date', __('Release date'))->default(date('Y-m-d'))->required();
        $form->number('length', __('Length'))->required()->rules('integer|min:1');
        $form->text('total_episodes', 'Total Episodes')->rules('nullable|integer|min:1');
        $form->multipleSelect('genres', __('Genres'))->options(MovieGenre::all()->pluck('name', 'id'))->required();
        $form->select('movie_category_id', __('Category'))->options(MovieCategory::all()->pluck('name', 'id'))->required();
        $form->select('movie_language_id', __('Language'))->options(MovieLanguage::all()->pluck('name', 'id'))->required();
        $form->select('movie_nation_id', __('Nation'))->options(MovieNation::all()->pluck('name', 'id'))->required();

        $form->belongsToMany('casts', CastSelectable::class, __('Casts'));

        if ($form->isCreating()) {
            $form->hasMany('trailers', __('Trailers'), function (Form\NestedForm $form) {
                $form->number('number', __('Number'))->required()->rules('integer|min:1');
                $form->select('quality', __('Quality'))->options([
                    '360' => '360p',
                    '480' => '480p',
                    '720' => '720p',
                    '1080' => '1080p',
                    '2160' => '2k',
                    '4096' => '4k',
                ])->required();
                $form->file('file', __('File'))->required()->rules('mimes:mp4');
            });
        }

        return $form;
    }
}
