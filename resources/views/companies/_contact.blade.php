<tr>
    <th scope="row">{{ $companies->firstItem() + $index }}</th>
    <td>{{ $company->name}}</td>
    <td>{{ $company->address }}</td>
    <td>{{ $company->email }}</td>
    <td>{{ $company->contacts->count() }}</td>
    <td width="150">
        @if ($showTrashButtons)
        <form action="{{ route('companies.restore', $company->id) }}" method="POST" style="display: inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-circle btn-outline-info" title="Restore"><i class="fa fa-undo"></i></button>
        </form>
        <form action="{{ route('companies.forceDelete', $company->id) }}" method="POST" onsubmit="return confirm('Your data will be removed permanently. Are you sure?')" style="display: inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-circle btn-outline-danger" title="Delete Permanently"><i class="fa fa-times"></i></button>
        </form>
        @else
        <a href="{{ route('companies.show', $company->id) }}" class="btn btn-sm btn-circle btn-outline-info" title="Show"><i class="fa fa-eye"></i></a>
        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-circle btn-outline-secondary" title="Edit"><i class="fa fa-edit"></i></a>
        @include('layouts._delete-form')
        @endif
    </td>
</tr>
