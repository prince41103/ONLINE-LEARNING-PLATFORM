document.addEventListener("DOMContentLoaded", () => {
    const signInBtn = document.getElementById("signInBtn");
    const registerBtn = document.getElementById("registerBtn");
    const signOutBtn = document.getElementById("signOutBtn");

    // Simulate a login check (Replace this with actual login check from backend or session)
    const isLoggedIn = localStorage.getItem("loggedIn") === "true";

    if (isLoggedIn) {
        // Hide Sign In/Register buttons and show Sign Out button
        signInBtn.style.display = "none";
        registerBtn.style.display = "none";
        signOutBtn.style.display = "inline-block";
    } else {
        // Show Sign In/Register buttons and hide Sign Out button
        signInBtn.style.display = "inline-block";
        registerBtn.style.display = "inline-block";
        signOutBtn.style.display = "none";
    }

    // Add logout functionality
    signOutBtn.addEventListener("click", () => {
        localStorage.setItem("loggedIn", "false"); // Simulate logout
    });
});
