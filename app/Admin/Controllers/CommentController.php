<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use App\Models\Game;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class CommentController extends AdminController
{
    protected $title = 'Comments';

    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('game.name', __('Game'));
        $grid->column('user_name', __('User Name'));
        $grid->column('user_image', __('User Image'))->image();
        $grid->column('rating', __('Rating'))->sortable();
        $grid->column('review', __('Review'))->limit(50);
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('game.name', __('Game'));
        $show->field('user_name', __('User Name'));
        $show->field('user_image', __('User Image'))->image();
        $show->field('rating', __('Rating'));
        $show->field('review', __('Review'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Comment());

        $form->select('game_id', __('Game'))->options(Game::all()->pluck('name', 'id'))->required();
        $form->text('user_name', __('User Name'))->required();
        $form->file('user_image', __('User Image'))
            ->default('default_user_image.jpg')
            ->move('images/user')
            ->name(function ($file) {
                return uniqid() . '_' . $file->getClientOriginalName();
            });
        $form->number('rating', __('Rating'))->min(0)->max(5)->required();
        $form->textarea('review', __('Review'))->required();

        return $form;
    }



}
