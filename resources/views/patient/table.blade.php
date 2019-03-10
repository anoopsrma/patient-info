<table class="table table-responsive-sm table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>औषधी/सेवा</th>
            <th>नाम</th>
            <th>रकम</th>
            <th>मिती</th>
        </tr>
    </thead>
    @if(count($data) > 0)
    <tbody>
        @foreach($data as $key => $row)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$row->type}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->price}}</td>
                <td>{{$row->created_at}}</td>
            </tr>
        @endforeach
    </tbody>
    @endif
</table>
