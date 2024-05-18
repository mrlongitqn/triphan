<li class="nav-item">
    <a href="{{ route('subjects.index') }}"
       class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}">
        <p>Môn học</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('levels.index') }}"
       class="nav-link {{ Request::is('levels*') ? 'active' : '' }}">
        <p>Khối lớp</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('courses.index') }}"
       class="nav-link {{ Request::is('courses*') ? 'active' : '' }}">
        <p>Lớp học</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('students.index') }}"
       class="nav-link {{ Request::is('students*') ? 'active' : '' }}">
        <p>Học viên</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('courseStudents.index') }}"
       class="nav-link {{ Request::is('courseStudents*') ? 'active' : '' }}">
        <p>Quản lý học</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('fees.index') }}"
       class="nav-link {{ Request::is('fees*') ? 'active' : '' }}">
        <p>Quản lý học phí</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('refunds.index') }}"
       class="nav-link {{ Request::is('refunds*') ? 'active' : '' }}">
        <p>Trả học phí</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('marks.index') }}"
       class="nav-link {{ Request::is('marks/*') ? 'active' : '' }}">
        <p>Quản lý điểm</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('marks.avg') }}"
       class="nav-link {{ Request::is('mark/avg-*') ? 'active' : '' }}">
        <p>Điểm trung bình</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('sessionMarks.index') }}"
       class="nav-link {{ Request::is('sessionMarks*') ? 'active' : '' }}">
        <p>Đợt nhập điểm</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('markTypes.index') }}"
       class="nav-link {{ Request::is('markTypes*') ? 'active' : '' }}">
        <p>Loại cột điểm</p>
    </a>
</li>
<li class="nav-item">
    <a href="javascript:"
       class="nav-link {{ Request::is('reports*') ? 'active' : '' }}">
        <p>Báo cáo thống kê <i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('reports.ExportDebtList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách chưa nộp học phí</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('reports.ReportCollect')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Báo cáo thu học phí</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('reports.ReportCollectRefund')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Báo cáo thu/trả học phí</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('reports.ReportCollectCancel')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Báo cáo hủy học phí</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('users') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p>Quản lý người dùng</p>
    </a>
</li>

{{--<li class="nav-item">--}}
{{--    <a href="{{ route('marks.index') }}"--}}
{{--       class="nav-link {{ Request::is('marks*') ? 'active' : '' }}">--}}
{{--        <p>Quản lý điểm</p>--}}
{{--    </a>--}}
{{--</li>--}}


{{--<li class="nav-item">--}}
{{--    <a href="{{ route('sessionMarks.index') }}"--}}
{{--       class="nav-link {{ Request::is('sessionMarks*') ? 'active' : '' }}">--}}
{{--        <p>Đợt nhập điểm</p>--}}
{{--    </a>--}}
{{--</li>--}}


{{--<li class="nav-item">--}}
{{--    <a href="{{ route('courseSessions.index') }}"--}}
{{--       class="nav-link {{ Request::is('courseSessions*') ? 'active' : '' }}">--}}
{{--        <p>Course Sessions</p>--}}
{{--    </a>--}}
{{--</li>--}}


{{--<li class="nav-item">--}}
{{--    <a href="{{ route('courseSessionStudents.index') }}"--}}
{{--       class="nav-link {{ Request::is('courseSessionStudents*') ? 'active' : '' }}">--}}
{{--        <p>Course Session Students</p>--}}
{{--    </a>--}}
{{--</li>--}}




{{--<li class="nav-item">--}}
{{--    <a href="{{ route('sessionMarkDetails.index') }}"--}}
{{--       class="nav-link {{ Request::is('sessionMarkDetails*') ? 'active' : '' }}">--}}
{{--        <p>Session Mark Details</p>--}}
{{--    </a>--}}
{{--</li>--}}







