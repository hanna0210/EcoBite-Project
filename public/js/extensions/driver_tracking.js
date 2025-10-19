$(function () {
    "use strict";

    var firestoreDB;
    var defaultProject;
    let map;
    let driverLocationMarker = [];
    let driverLocationMarkerIds = [];
    let markerIconUrl = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

    //
    function loadMapView() {
        // Get Mapbox API key from the map container's data attribute
        const mapContainer = document.getElementById("map");
        const mapboxToken = mapContainer.dataset.mapboxToken;
        
        if (!mapboxToken) {
            console.error("Mapbox token is required");
            alert("Please configure your Mapbox API key in the extension settings");
            return;
        }

        mapboxgl.accessToken = mapboxToken;
        
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [0.0, 0.0], // [lng, lat] format for Mapbox
            zoom: 2
        });

        // Add navigation controls
        map.addControl(new mapboxgl.NavigationControl());
    }

    //
    livewire.on("loadMap", data => {
        //
        markerIconUrl = data;

        //
        loadMapView();
    });

    //
    livewire.on("authenticateUser", data => {

        //
        var firebaseConfig = {
            apiKey: "" + data[0] + "",
            projectId: "" + data[1] + "",
            messagingSenderId: "" + data[2] + "",
            appId: "" + data[3] + "",
        };
        // Initialize Firebase
        defaultProject = firebase.initializeApp(firebaseConfig, "driverTracking");
        //
        firebase.auth(defaultProject)
            .signInWithCustomToken(data[4])
            .then(userCredential => {
                // Signed in
                var user = userCredential.user;

                firestoreDB = defaultProject.firestore();
                // ...
                console.log("Authenticated");
            })
            .catch(error => {
                var errorCode = error.code;
                var errorMessage = error.message;
                // ...
                alert("Authentication failed:: " + errorCode + " " + errorMessage + " ");
            });
    });

    //
    livewire.on("loadDriversOnMap", data => {
        //
        driverLocationMarker.forEach(marker => {
            marker.remove(); // Mapbox uses .remove() instead of .setMap(null)
        });
        driverLocationMarkerIds = [];
        driverLocationMarker = [];

        data.forEach(driver => {
            listenToDriverNodeOnFCM(driver);
        });
    });

    //listen to driver locations on firebase
    function listenToDriverNodeOnFCM(driver) {
        //
        firestoreDB
            .collection("drivers")
            .doc("" + driver["id"] + "")
            .onSnapshot(doc => {
                //
                let driverLocationData = doc.data();

                if (driverLocationData) {
                    //
                    addMarker(
                        {
                            lat: driverLocationData.lat,
                            lng: driverLocationData.long
                        },
                        driver
                    );
                }
            });
    }

    //
    function addMarker(location, driver) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        //
        const driverId = driver["id"];
        const driverName = driver["name"];
        const driverPhone = driver["phone"];
        const driverPhoto = driver["photo"];
        const driverIsOnline = driver["is_online"];
        const driverTotalAssignedOrders = driver["currently_assigned_orders_count"];

        if (!driverLocationMarkerIds.includes(driverId)) {
            // Create a custom marker element
            const markerEl = document.createElement('div');
            markerEl.className = 'custom-marker';
            markerEl.style.backgroundImage = `url(${markerIconUrl})`;
            markerEl.style.width = '40px';
            markerEl.style.height = '40px';
            markerEl.style.backgroundSize = 'contain';
            markerEl.style.backgroundRepeat = 'no-repeat';
            markerEl.style.cursor = 'pointer';

            // Create the marker
            const marker = new mapboxgl.Marker({
                element: markerEl
            })
                .setLngLat([location.lng, location.lat]) // Mapbox uses [lng, lat] format
                .addTo(map);

            var statusTag = "<div class='w-4 h-2 p-2 rounded bg-red-500'></div>";
            if (driverIsOnline) {
                statusTag = "<div class='w-4 h-2 p-2 rounded bg-green-500'></div>";
            }

            //infowindow content
            const infoContent = document.getElementById("infoContent").cloneNode(true);
            infoContent.style.display = 'block';

            // Update elements INSIDE #infoContent
            infoContent.querySelector("#driverPhoto").src = driverPhoto;
            infoContent.querySelector("#driverName").textContent = driverName;
            infoContent.querySelector("#driverPhone").textContent = driverPhone;
            infoContent.querySelector("#driverPhone").href = `tel:${driverPhone}`;
            infoContent.querySelector("#statusTag").innerHTML = statusTag;

            // assignedOrderInfo
            const assignedOrderInfoDiv = infoContent.querySelector("#assignedOrderInfo");
            if (driverTotalAssignedOrders <= 0) {
                assignedOrderInfoDiv.style.display = "none";
            } else {
                assignedOrderInfoDiv.style.display = "block";
                // assigedOrdersTotalCount
                infoContent.querySelector("#assigedOrdersTotalCount").textContent = driverTotalAssignedOrders;
                // viewAssigedOrdersLink
                const baseLink = infoContent.querySelector("#orderHerfLink").textContent;
                const ordersLink = baseLink + driverName + "";
                infoContent.querySelector("#viewAssigedOrdersLink").href = ordersLink;
                infoContent.querySelector("#viewAssigedOrdersLink").target = "__blank";
            }

            // Create Mapbox popup
            const popup = new mapboxgl.Popup({
                offset: 40,
                closeButton: true,
                closeOnClick: false
            }).setHTML(infoContent.innerHTML);

            // Attach popup to marker
            marker.setPopup(popup);

            // Show popup on marker click
            markerEl.addEventListener('click', () => {
                popup.addTo(map);
            });

            //
            driverLocationMarkerIds.push(driverId);
            driverLocationMarker.push(marker);
        }
        //marker already exists, so just update the location
        else {
            let driverIdIndex = driverLocationMarkerIds.indexOf(driverId);
            driverLocationMarker[driverIdIndex].setLngLat([location.lng, location.lat]);
        }
    }
});
