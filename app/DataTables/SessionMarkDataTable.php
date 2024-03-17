<?php

namespace App\DataTables;

use App\Models\SessionMark;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SessionMarkDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'session_marks.datatables_actions')
            ->editColumn('start_date', function ($s){
                return $s->start_date->format('d/m/Y');
            })->editColumn('end_date', function ($s){
                return $s->end_date->format('d/m/Y');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SessionMark $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SessionMark $model)
    {
        return $model->newQuery();
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
//                'buttons'   => [
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
//                ],
            ])->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->hidden(),
           Column::make( 'session')->title('Tên đợt'),
           Column::make( 'start_date')->title('Ngày bắt đầu'),
           Column::make( 'end_date')->title('Ngày kết thúc'),
          // Column::make( 'scores')->title('Cột điểm'),
           Column::make( 'desc')->title('Mô tả'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'session_marks_datatable_' . time();
    }
}
