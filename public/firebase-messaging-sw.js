importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyACAtIbXFrOnUy-_l-rvT3HHR0OarhqkEs",

    authDomain: "victoira-e0643.firebaseapp.com",

    projectId: "victoira-e0643",

    storageBucket: "victoira-e0643.appspot.com",

    messagingSenderId: "236393939756",

    appId: "1:236393939756:web:375bf6c41f69b1ea0b2289",

    measurementId: "G-FT1P390BTJ"

};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

try {
    messaging.setBackgroundMessageHandler(function(payload) {
        console.log("Message received.", payload);
        const title = "Hello world is awesome";
        const options = {
            body: "Your notification message.",
            icon: "/firebase-logo.png",
        };
        return self.registration.showNotification(
            title,
            options
        );
    });
} catch (error) {
    console.error('Failed to register service worker:', error);
}

