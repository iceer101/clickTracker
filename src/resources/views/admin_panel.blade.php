<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ClickTracker</title>
    <link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css">
    <script type="text/javascript" charset="utf8" src="assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/datatables.min.js"></script>

</head>
<body>

<div style="margin: 3%">
    <h2>Clicks</h2>
    <table id="clicks" class="display" style="width: 100%;">
        <thead>
        <tr>
            <th>id</th>
            <th>ua</th>
            <th>ip</th>
            <th>ref</th>
            <th>param1</th>
            <th>param2</th>
            <th>error</th>
            <th>bad_domain</th>
        </tr>
        </thead>
    </table>
    <br>
    <h2>Bad Domains</h2>
    <table id="bad_domains" class="display">
        <thead>
        <tr>
            <th>id</th>
            <th>name</th>
        </tr>
        </thead>
    </table>
    <button id="addBadDomain">Add bad domain</button>
</div>


</body>


<script>
    $(document).ready(function () {
        $('#clicks').DataTable({"ajax": '/getClicks'});
        const badDomainsTable = $('#bad_domains').DataTable({"ajax": '/getBadDomains'});

        document.querySelector(`#addBadDomain`).addEventListener('click', async () => {
            let name = prompt("Please enter domain name", "google.com");
            if (!name) return;

            await fetch('/addBadDomain', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": "{{csrf_token()}}"
                },
                body: JSON.stringify({name})
            });
            badDomainsTable.ajax.reload();
        })
    });
</script>
</html>
