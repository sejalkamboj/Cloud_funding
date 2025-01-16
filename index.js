document.addEventListener("DOMContentLoaded", () => {
    // Mock data for campaigns
    const campaigns = [
        { name: "Clean Water Initiative", amountRaised: 15000, goal: 20000 },
        { name: "Healthcare for Rural Areas", amountRaised: 7000, goal: 10000 },
        { name: "Education for All", amountRaised: 12500, goal: 15000 }
    ];

    // Elements for the search functionality
    const searchButton = document.getElementById('search-button');
    const searchInput = document.getElementById('search-input');

    // Check if the user is trying to access login for payment
    function checkPaymentIntent() {
        const urlParams = new URLSearchParams(window.location.search);
        const intent = urlParams.get('intent');

        if (intent !== 'pay') {
            // Redirect to the home page if no payment intent is found
            alert('Access denied! You can only log in here if you intend to make a payment.');
            window.location.href = 'index.html';
        }
    }

    // Handle search button click to filter campaigns
    searchButton.addEventListener('click', () => {
        const query = searchInput.value.toLowerCase();
        const filteredCampaigns = campaigns.filter(campaign =>
            campaign.name.toLowerCase().includes(query)
        );

        if (filteredCampaigns.length > 0) {
            alert(Found ${filteredCampaigns.length} campaign(s) matching "${query}");
            // Here you could populate results into a section on the page
        } else {
            alert(No campaigns found matching "${query}");
        }
    });

    // Call the checkPaymentIntent function on page load
    checkPaymentIntent();
});
