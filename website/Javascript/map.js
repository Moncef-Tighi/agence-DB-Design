const latitude = document.querySelector("#latitude").innerText
const longitude = document.querySelector("#longitude").innerText
let map = L.map('map').setView([latitude,longitude], 16);
console.log("test");
L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
L.marker([latitude,longitude]).addTo(map);  
