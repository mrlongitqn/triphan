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


