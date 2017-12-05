function Home() {
    this.init = function () {
        $.ajax({
            url: 'getAllParks',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {

                $("#tblParks tbody").html("<tr><td>Total este mes</td><td>" + resp.quantity.count + "</td></tr>");

            }
        })

        $.ajax({
            url: 'getAllStakeholder',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                var html = "";
                $.each(resp.quantity, function (i, val) {
                    html += "<tr><td>" + val.role_id + "</td><td>" + val.total + "</td></tr>";
                })

                $("#tblStake tbody").html(html);
            }
        })

        $.ajax({
            url: 'getAllOrders',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                var html = "";
                $.each(resp.quantity, function (i, val) {
                    html += "<tr><td>" + val.status + "</td><td>" + val.count + "</td></tr>";
                })

                $("#tblOrders tbody").html(html);

            }
        })
    }
}


obj = new Home();
obj.init();
