<x-announcement-form methodValue="PATCH" actionValue="{!!'/announcement/'.$announcement->id!!}" titleValue="{!! $announcement->title !!}" contentValue="{!!$announcement->content!!}" type="edit">
    <x-slot name='method' >
        @method('PATCH')
    </x-slot>
</x-announcement-form>
