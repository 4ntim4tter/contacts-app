<select class="custom-select" name="company_id" id='search-select' onchange="this.form.submit()">
    <option value="" selected>All Companies</option>
    @foreach ($companies as $id => $company)
    <option value="{{ $id }}" @if($id==request()->query("company_id")) selected @endif>{{ $id . " " . $company->name }}</option>
    @endforeach
</select>
