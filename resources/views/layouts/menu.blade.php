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
        <p>Course Students</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('fees.index') }}"
       class="nav-link {{ Request::is('fees*') ? 'active' : '' }}">
        <p>Fees</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('marks.index') }}"
       class="nav-link {{ Request::is('marks*') ? 'active' : '' }}">
        <p>Marks</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('sessionMarks.index') }}"
       class="nav-link {{ Request::is('sessionMarks*') ? 'active' : '' }}">
        <p>Session Marks</p>
    </a>
</li>


