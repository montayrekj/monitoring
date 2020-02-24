<div class="sidebar" style="width: 20%; height: 100%; background-color: #192841; float:left; color: white; padding: 10px 20px;">
    <ul style="padding: 0px; list-style-type: none;" class="sample">
        <a href="/admin/sections" class="<?php if($selected == 'sections'){echo 'active';}?>">
            <li>
            <i class="fas fa-user-friends"></i>Sections
            </li>
        </a>
        <a href="/admin/subjects" class="<?php if($selected == 'subjects'){echo 'active';}?>">
            <li>
            <i class="fas fa-book-open"></i>Subjects
            </li>
        </a>
        <a href="/admin/teachers" class="<?php if($selected == 'teachers'){echo 'active';}?>">
            <li>
            <i class="fas fa-user-tie"></i>Teachers
            </li>
        </a>
        <a href="/admin/schedules" class="<?php if($selected == 'schedules'){echo 'active';}?>">
            <li>
            <i class="fas fa-calendar-alt"></i>Schedules
            </li>
        </a>
        <a href="/admin/changePassword" class="<?php if($selected == 'changePassword'){echo 'active';}?>">
            <li>
                <i class="fas fa-cogs"></i>Change Password
            </li>
        </a>
        <a href="/logout">
            <li>
                <i class="fas fa-user-friends"></i>Logout
            </li>
        </a>
    </ul>
</div>