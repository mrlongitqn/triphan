<?php

namespace App\DataTables;

use App\Models\Fee;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class FeeDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'fees.datatables_actions')->editColumn('created_at',function ($fee){
            return Carbon::parse($fee->created_at)->format('H:i d/m/Y');
        })->editColumn('payment_type',function ($fee){
            switch ($fee->payment_type){
                case 0: return 'Tiền mặt';
                case 1: return  'Chuyển khoản';
                case 2: return 'Quẹt thẻ';
                default: return $fee->payment_type;
            }

        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Fee $model)
    {
        return $model->newQuery()
            ->leftJoin('courses', 'courses.id', '=', 'fees.course_id')
            ->leftJoin('students', 'students.id', '=', 'fees.student_id')
            ->leftJoin('users', 'users.id', '=', 'fees.user_id')->select('fees.*', 'fullname', 'name', 'course');
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
              //  'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
//                'buttons'   => [
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
//                ],
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
            Column::make('id','fees.id')->hidden(),
            Column::make('fee_code')->title('Mã HĐ'),
            Column::make('fullname','students.fullname')->title('Học viên'),
            Column::make('course', 'courses.course')->title('Lớp học'),
            Column::make('amount')->title('Số tiền')->renderJs('number', ',','.'),
            Column::make('created_at', 'fees.created_at')->title('Thời gian'),
            Column::make('payment_type', 'fees.created_at')->title('Hình thức'),
            Column::make('name','users.name')->title('Người thu'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'fees_datatable_' . time();
    }
}
