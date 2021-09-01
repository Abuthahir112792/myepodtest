(function($) {
  (function() {

    var db = {

      loadData: function(filter) {
        return $.grep(this.clients, function(client) {
          return (!filter.Name || client.Name.indexOf(filter.Name) > -1) &&
            (filter.Age === undefined || client.Age === filter.Age) &&
            (!filter.Address || client.Address.indexOf(filter.Address) > -1) &&
            (!filter.Country || client.Country === filter.Country) &&
            (filter.Married === undefined || client.Married === filter.Married);
        });
      },

      insertItem: function(insertingClient) {
        this.clients.push(insertingClient);
      },

      updateItem: function(updatingClient) {},

      deleteItem: function(deletingClient) {
        var clientIndex = $.inArray(deletingClient, this.clients);
        this.clients.splice(clientIndex, 1);
      }

    };

    window.db = db;


    db.countries = [{
        Name: "",
        Id: 0
      },
      {
        Name: "PICKUP ARRANGED",
        Id: 1
      },
      {
        Name: "COLLECTING",
        Id: 2
      },
      {
        Name: "PICKED UP",
        Id: 3
      },
      {
        Name: "DEPARTURE",
        Id: 4
      },
      {
        Name: "IN TRANSIT",
        Id: 5
      },
      {
        Name: "DELIVERED",
        Id: 6
      },
    ];

    db.clients = [{
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      },
      {
        "Date": "19-07-2021",
        "Time": "10.10 AM",
        "Status": 1,
        "Activity": "Pickup Arranged Monday Morning",
        "Active": false
      }
    ];

  }());
})(jQuery);