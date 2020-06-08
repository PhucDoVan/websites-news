@foreach($childs as $child)
    <tr class="child-level" data-level="{{ $childLevel }}">
        <td>{{ $child->name }}</td>
        <td>
            <a href="{{ route('group.edit', $child->id) }}"
               class="btn btn-primary btn-sm">
                <span data-feather="edit"></span> {{ trans('tool/group.label.list.button_edit') }}
            </a>
        </td>
    </tr>

    @if(count($child->childs))
        @include('group.child', [
            'childs' => $child->childs,
            'childLevel' => $childLevel + 1
        ])
    @endif
@endforeach
