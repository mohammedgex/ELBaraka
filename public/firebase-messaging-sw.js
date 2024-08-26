// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

try
{
    // Initialize the Firebase app in the service worker by passing in
    // your app's Firebase config object.
    // https://firebase.google.com/docs/web/setup#config-object
    firebase.initializeApp({
        apiKey: "AIzaSyCKtmVnuj8HPtK_G1HKOXGYCYA9j7oP0Yk",
        authDomain: "barakatrans-4e936.firebaseapp.com",
        databaseURL: "https://barakatrans-4e936-default-rtdb.firebaseio.com",
        projectId: "barakatrans-4e936",
        storageBucket: "barakatrans-4e936.appspot.com",
        messagingSenderId: "1054782259941",
        appId: "1:1054782259941:web:f1fd7a5fcd9881ae370a0c",
        measurementId: "G-QNWHQNB96B"
    });


    // Retrieve an instance of Firebase Messaging so that it can handle background
    // messages.
    const messaging = firebase.messaging();

    messaging.onBackgroundMessage((payload) => {
    //
        

        let options = {
            body: "",
            icon: "",
            image: "",
            tag: "alert",
        };

        if(payload.data.body){
            options.body = payload.data.body;
        }

        if(payload.data.image){
            options.icon = payload.data.image;
        }

        let notification = self.registration.showNotification(
            payload.data.title,
            options
        );

        if(payload.data.url){
            // link to page on clicking the notification
            notification.onclick = (payload) => {
                window.open(payload.data.url);
            };
        }
    });
}
catch(e) {
    console.log(e)
}
