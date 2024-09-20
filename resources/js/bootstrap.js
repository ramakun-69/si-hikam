/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? "mt1",
    wsHost: import.meta.env.VITE_PUSHER_HOST
        ? import.meta.env.VITE_PUSHER_HOST
        : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
});
window.Echo.channel("attendance-channel").listen(
    ".attendance-checked-in",
    (e) => {
        console.log("Attendance updated", e.attendance);
        refreshQrCheckInList();
    }
);
window.Echo.channel("attendance-channel").listen(
    ".attendance-checked-out",
    (e) => {
        console.log("Attendance updated", e.attendance);
        refreshQrCheckOutList();
    }
);
function showLoading() {
    $("#loading").removeClass("d-none");
}

function hideLoading() {
    $("#loading").addClass("d-none");
    // $("#spinner").addClass('d-none');
}
function refreshQrCheckInList() {
    const appUrl = import.meta.env.VITE_APP_URL;
    $.ajax({
        type: "GET",
        url: appUrl + "/attendance/check-in/get-qr",
        dataType: "json",
        beforeSend: function () {
            $("#qr").empty();
            showLoading();
        },
        success: function (response) {
           
            $("#qr").append(response);
            hideLoading();
        },
        error: function () {
            hideLoading();
            console.error("Terjadi kesalahan saat memuat QR code");
        },
    });
}
function refreshQrCheckOutList() {
    const appUrl = import.meta.env.VITE_APP_URL;
    $.ajax({
        type: "GET",
        url: appUrl + "/attendance/check-out/get-qr",
        dataType: "json",
        beforeSend: function () {
            $("#qr").empty();
            showLoading();
        },
        success: function (response) {
           
            $("#qr").append(response);
            hideLoading();
        },
        error: function () {
            hideLoading();
            console.error("Terjadi kesalahan saat memuat QR code");
        },
    });
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
