{!! Form::open(['route' => ['levels.destroy', $id], 'method' => 'delete', 'class'=>'text-center']) !!}
<div class='btn-group'>
    {{--    <a href="{{ route('levels.show', $id) }}" class='btn btn-default btn-xs'>--}}
    {{--        <i class="fa fa-eye"></i>--}}
    {{--    </a>--}}
    @if(str_contains($file_download, 'wait'))
        <a title="File đang trong quá trình nén. Vui lòng đợi..." class='btn btn-default btn-xs'>
            <i class="fa fa-spinner"></i>
        </a>
    @else
        @if(str_contains($file_download, 'done'))
            <a href="{{ route('report.downloadTotal', $id) }}" title="Tải về file báo cáo tổng hợp"
               class='btn btn-default btn-xs'>
                <i class="fa fa-download"></i>
            </a>
        @endif
        <a href="{{ route('report.exportTotal', $id) }}" title="Tạo file báo cáo tổng hợp mới"
           class='btn btn-default btn-xs'>
            <i class="fa fa-sync"></i>
        </a>
    @endif

    <a href="{{ route('levels.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>

    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Bạn có chắc chắn xóa?')"
    ]) !!}
</div>
{!! Form::close() !!}
