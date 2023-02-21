<div>
    <form title="logout" wire:submit.prevent="logoutConfirm">
        <button type="submit" class="container flex mb-4 py-2 hover:bg-white hover:rounded-lg transition duration-300">
            <img src="{{asset('/src/img/icons/logout.png')}}" width="40px" class="mx-auto" alt="">
        </button>
    </form>
</div>
