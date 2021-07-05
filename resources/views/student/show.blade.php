@foreach($student as $item)
<tr>
    <th scope="row">{{ $loop->iteration }}</th>
    <td>{{ $item->name }}</td>
    <td>{{ $item->roll }}</td>
    <td>action</td>
  </tr>
  @endforeach