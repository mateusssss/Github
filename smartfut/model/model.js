bootbox.alert({
    message: "This is an alert with a callback!",
    callback: function () {
        console.log('This was logged in the callback!');
    }
})