<!DOCTYPE html>
<html>

<head>
    <title>KLEDO PAYMENT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <h2>KLEDO PAYMENT</h2>
    <h3>Data Payment</h3>

    <div>
        <input type="text" name="name" />
        <button id="btnTambah" data-url="{{route('payments.store')}}">+ Tambah</button>
    </div>

    <br />
    <br />
    <button id="delete_now">Delete</button>
    <p class="notif_msg"></p>

    <table border="1" id="tablePayment">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th><input type="checkbox" id="check_all" name="check_all" value="" data-url="{{route('payments.delete')}}" /> Delete</th>
        </tr>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ $payment->name }}</td>
            <td>
                <input type="checkbox" class="del_chk" name="id[]" value="{{ $payment->id }}" />
            </td>
        </tr>
        @endforeach
    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        $("#check_all").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $('#btnTambah').on('click', function(e) {
            let name = $("input[name='name']").val();
            $.ajax({
                url: $(this).data('url'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: name
                },
                success: function(res) {
                    if (res['meta']['status']) {
                        // $(".del_chk:checked").each(function() {
                        //     $(this).parents("tr").remove();
                        // });
                        let payment = res['data']['payment'];
                        $('#tablePayment tr:last').after(`<tr><td>${payment?.id}</td><td>${payment?.name}</td><td> <input type="checkbox" class="del_chk" name="id[]" value="${payment?.id}" /></td></tr>`);
                        alert(res['meta']['message'])
                    } else {
                        alert("Error");
                    }
                },
                error: function(data) {
                    alert(data.responseText);
                }
            });
        })

        $('#delete_now').on('click', function(e) {


            var allVals = [];
            $(".del_chk:checked").each(function() {
                allVals.push($(this).val());
            });
            // console.log(allVals);

            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {


                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {

                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            ids: allVals
                        },
                        success: function(data) {
                            if (data['meta']) {
                                // $(".del_chk:checked").each(function() {
                                //     $(this).parents("tr").remove();
                                // });
                            } else {
                                alert("Error");
                            }
                        },
                        error: function(data) {
                            alert(data.responseText);
                        }
                    });

                    $.each(allVals, function(index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });
    </script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('0690d53dac546c2277f8', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('pusher-delete');
        let count = 0;
        channel.bind('my-event', function(res) {
            console.log(res)
            count += 1;
            $(`.del_chk:checked[value="${res?.id}"]`).parents("tr").remove();
            $('.notif_msg').text("Telah Berhasil Menghapus " + count + " Data")
        });
        if (count == 0) {
            $('.notif_msg').text("")
        }
        $('.notif_msg').text("")
    </script>
</body>

</html>
