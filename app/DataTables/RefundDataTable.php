<?php

namespace App\DataTables;

use App\Models\Refund;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RefundDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'refunds.datatables_actions')->editColumn('created_at', function ($fee) {
            return Carbon::parse($fee->created_at)->format('H:i d/m/Y');
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Refund $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Refund $model)
    {
        return $model->newQuery()->leftJoin('students', 'students.id', '=', 'refunds.student_id')
            ->leftJoin('users', 'users.id', '=', 'refunds.user_id')
            ->select('refunds.*', 'students.fullname', 'users.name');
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
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'buttons' => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
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
            Column::make('id', 'refunds.id')->hidden(),
            Column::make('created_at', 'refunds.created_at')->title('Thời gian'),
            Column::make('fullname', 'students.fullname')->title('Học viên'),
            Column::make('total')->title('Số tiền trên HĐ')->renderJs('number', ',', '.'),
            Column::make('amount')->title('Số tiền hoàn trả')->renderJs('number', ',', '.'),
            Column::make('reason', 'refunds.reason')->title('Lý do'),
            Column::make('name', 'users.name')->title('Người trả'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'refunds_datatable_' . time();
    }
}
