<?php

namespace App\Admin\Controllers;

use App\Models\Game;
use App\Models\Console;
use App\Models\Category;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class GameController extends AdminController
{
    protected $title = 'Games';

    protected function grid()
    {
        $grid = new Grid(new Game());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('category.name', __('Category'))->sortable();
        $grid->column('price', __('Price'))->sortable();
        $grid->column('discounted_price', __('Discounted Price'))->sortable();
        $grid->column('stock', __('Stock'))->sortable();
        $grid->column('active', __('Active'))->bool();
        $grid->column('consoles', __('Consoles'))->display(function ($game) {
            if (is_object($game) && isset($game->consoles)) {
                return $game->consoles->pluck('name')->implode(', ');
            }
            return 'Ver consolas';
        });
        $grid->column('is_popular', __('Is Popular'))->bool();
        $grid->column('image')->image();
        $grid->column('release_date', __('Release Date'))->sortable();

        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        // Filtros
        $grid->filter(function ($filter) {
            $filter->like('name', 'Name');
            $filter->equal('category_id', 'Category')->select(Category::all()->pluck('name', 'id'));
            $filter->equal('is_popular', 'Popular')->select([1 => 'Yes', 0 => 'No']);
            $filter->equal('active', 'Active')->select([1 => 'Yes', 0 => 'No']);
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Game::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Name'));
        $show->field('category.name', __('Category'));
        $show->field('price', __('Price'));
        $show->field('discounted_price', __('Discounted Price'));
        $show->field('stock', __('Stock'));
        $show->field('active', __('Active'))->bool();
        $show->field('consoles', __('Consoles'))->as(function ($consoles) {
            return $consoles->pluck('name')->implode(', ');  // Muestra las consolas separadas por coma
        });
        $show->field('is_popular', __('Is Popular'))->bool();
        $show->field('image')->image();
        $show->field('description', __('Description'));
        $show->field('release_date', __('Release Date'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Game());

        $form->text('name', __('Name'))->required();
        $form->select('category_id', __('Category'))->options(Category::all()->pluck('name', 'id'))->required();
        $form->decimal('price', __('Price'))->required();
        $form->decimal('discounted_price', __('Discounted Price'))->default(null);
        $form->number('stock', __('Stock'))->default(0)->min(0);
        $form->multipleSelect('consoles', __('Consoles'))->options(
            Console::all()->pluck('name', 'id')  // Carga las consolas disponibles
        )->required();  // Es obligatorio seleccionar al menos una consola
        $form->switch('active', __('Active'))->default(1);
        $form->switch('is_popular', __('Is Popular'));
        $form->file('image', __('Image'))->uniqueName()->move('images/games');
        $form->textarea('description', __('Description'));
        $form->date('release_date', __('Release Date'))->required();

        return $form;
    }
}
