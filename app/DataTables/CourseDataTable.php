<?php

namespace App\DataTables;

use App\Models\Course;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CourseDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', 'courses.datatables_actions')->editColumn('start_date', function ($course){
            return date('d/m/Y', strtotime($course->start_date) );
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Course $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $model)
    {
        return $model->newQuery()->leftJoin('levels','levels.id','=','courses.level_id')->leftJoin('subjects', 'subjects.id', '=', 'courses.subject_id')
            ->select('courses.*', 'level', 'subject')->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title'=>'Hành động'])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('course')->title('Lớp học'),
            Column::make('subject','subjects.subject')->title('Môn học'),
            Column::make('level','levels.level')->title('Khối lớp'),
            Column::make('fee')->title('Học phí')->renderJs('number', ',','.'),
            Column::make('start_date')->title('Ngày mở'),
            Column::make('open')->title('Giờ bắt đầu'),
            Column::make('close')->title('Giờ kết thúc'),
            Column::make('schedules')->title('Lịch học'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'courses_datatable_' . time();
    }
}
