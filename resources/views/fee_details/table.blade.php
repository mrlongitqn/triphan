<div class="table-responsive">
    <table class="table" id="feeDetails-table">
        <thead>
        <tr>
            <th>Origin</th>
        <th>Amount</th>
        <th>Remain</th>
        <th>Month</th>
        <th>Year</th>
        <th>Note</th>
        <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($feeDetails as $feeDetail)
            <tr>
                <td>{{ $feeDetail->origin }}</td>
            <td>{{ $feeDetail->amount }}</td>
            <td>{{ $feeDetail->remain }}</td>
            <td>{{ $feeDetail->month }}</td>
            <td>{{ $feeDetail->year }}</td>
            <td>{{ $feeDetail->note }}</td>
            <td>{{ $feeDetail->status }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['feeDetails.destroy', $feeDetail->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('feeDetails.show', [$feeDetail->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('feeDetails.edit', [$feeDetail->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
