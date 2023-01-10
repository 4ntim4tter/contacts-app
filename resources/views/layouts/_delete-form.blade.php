<form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display: inline">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-circle btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></button>
</form>
