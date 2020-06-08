@foreach($childs as $child)
    @if( $isAddPage || $groupEdit->id != $child->id)
        <option class="p-1 child-level"
                {{ old('parent_group_id', optional($groupEdit)->parent_group_id) == $child->id ? 'selected' : '' }}
                value="{{ $child->id }}">
            {!! str_repeat($space, $childLevel) !!} {{ $child->name }}
        </option>

        @if(count($child->childs))
            @include('group.child-select', [
                'childs' => $child->childs,
                'childLevel' => $childLevel + 1
            ])
        @endif
    @endif
@endforeach
