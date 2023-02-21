<div>
    <div class="rounded-lg bg-primary dark:bg-slate-700 h-full lg:w-[70px] right-0 fixed my-auto">                
        <div id="nav-menu-aside" class="w-full mb-12 pt-10 my-auto justify-center items-center">
            <a title="dashboard" href="/dashboard" class="">
                <div class="container flex mb-4 py-2 hover:bg-white hover:rounded-lg transition duration-300">
                    <img src="/src/img/icons/dashboard.png" width="40px" class="mx-auto" alt="">
                </div>
            </a>
            @if(auth()->user()->role_id == 3)
            <a title="register" href="/student-register" class="">
                <div class="container flex mb-4 py-2 hover:bg-white hover:rounded-lg transition duration-300">
                    <img src="/src/img/icons/register.png" width="40px" class="mx-auto" alt="">
                </div>
            </a>
            @endif
            @if(auth()->user()->role_id == 1)
            <a title="calender" href="/calendar" class="">
                <div class="container flex mb-4 py-2 hover:bg-white hover:rounded-lg transition duration-300">
                    <img src="/src/img/icons/calendar.png" width="40px" class="mx-auto" alt="">
                </div>
            </a>
            <a title="users" href="/users" class="">
                <div class="container flex mb-4 py-2 hover:bg-white hover:rounded-lg transition duration-300">
                    <img src="/src/img/icons/man.png" width="40px" class="mx-auto" alt="">
                </div>
            </a>
            @endif
            <a title="profile"  href="/user/profile" class="">
                <div class="container flex mb-4 py-2 hover:bg-white hover:rounded-lg transition duration-300">
                    <img src="/src/img/icons/user.png" width="40px" class="mx-auto" alt="">
                </div>
            </a>
            <livewire:auth.logout/>
        </div>
    </div>
</div>