async function fetchVehicles() {
    try {
        const response = await fetch('backend/get_vehicles.php');
        const vehicles = await response.json();
        displayVehicles(vehicles);
    } catch (error) {
        console.error("Error fetching vehicles:", error);
    }
}

function displayVehicles(vehicles) {
    const vehicleList = document.getElementById('vehicleList');
    vehicleList.innerHTML = ''; // Kosongkan daftar kendaraan terlebih dahulu

    vehicles.forEach(vehicle => {
        const vehicleDiv = document.createElement('div');
        vehicleDiv.className = 'vehicle-card';

        vehicleDiv.innerHTML = `
            <h3>${vehicle.car_name}</h3>
            <p>Type: ${vehicle.type_car}</p>
            <button onclick="showRentalPopup(${vehicle.rental_id})">Book</button>
        `;
        vehicleList.appendChild(vehicleDiv);
    });
}

function showRentalPopup(rentalId) {
    document.getElementById('rentalVehicleId').value = rentalId;
    document.getElementById('rentalPopup').style.display = 'flex';
}

function closePopup() {
    document.getElementById('rentalPopup').style.display = 'none';
}

document.getElementById('rentVehicleForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const rentalId = document.getElementById('rentalVehicleId').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const bookingNotes = document.getElementById('bookingNotes').value;

    try {
        const response = await fetch('backend/rent_vehicle.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                rentalId: rentalId,
                startDate: startDate,
                endDate: endDate,
                bookingNotes: bookingNotes
            })
        });

        const result = await response.json();
        alert(result.message);
        closePopup();
        fetchVehicles();
    } catch (error) {
        console.error("Error renting vehicle:", error);
    }
});

fetchVehicles();
