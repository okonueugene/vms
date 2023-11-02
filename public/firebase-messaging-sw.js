// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
// firebase.initializeApp({
//     apiKey: "AIzaSyCwsKNDXae_U6PVp28rUsyeUVLZJGd2JsQ",
//     authDomain: "visitor-app-f4cf8.firebaseapp.com",
//     projectId: "visitor-app-f4cf8",
//     storageBucket: "visitor-app-f4cf8.appspot.com",
//     messagingSenderId: "916840265010",
//     appId: "1:916840265010:web:0a79ffc97842d18924932b",
//     measurementId: "G-B6CDGMQ910"
// });
// Your web app's Firebase configuration
const firebaseConfig = {
      apiKey: "AIzaSyDAJGpsxJMSskkkoJSTe8qQUw2NiITpyOw",
      authDomain: "visitor-management-syste-85308.firebaseapp.com",
      projectId: "visitor-management-syste-85308",
      storageBucket: "visitor-management-syste-85308.appspot.com",
      messagingSenderId: "574318872849",
      appId: "1:574318872849:web:7a850760608d344b1de4b0"
    };

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});