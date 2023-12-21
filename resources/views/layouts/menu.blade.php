<li class="nav-item">
    <a href="{{ route('subjects.index') }}"
       class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}">
        <p>Subjects</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('levels.index') }}"
       class="nav-link {{ Request::is('levels*') ? 'active' : '' }}">
        <p>Levels</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('courses.index') }}"
       class="nav-link {{ Request::is('courses*') ? 'active' : '' }}">
        <p>Courses</p>
    </a>
</li>



