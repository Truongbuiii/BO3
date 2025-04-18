function showUserPopup() {
    if (document.getElementById("user-popup")) {
        document.getElementById("user-popup").style.display = "flex";
        return;
    }

    const popup = document.createElement("div");
    popup.id = "user-popup";
    popup.className = "popup";
    popup.style.cssText = `
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000;
    `;

    const popupContent = document.createElement("div");
    popupContent.className = "popup-content";
    popupContent.style.cssText = `
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
        position: relative;
        min-width: 320px;
    `;

    const closeButton = document.createElement("span");
    closeButton.innerHTML = "&times;";
    closeButton.style.cssText = `
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #888;
    `;
    closeButton.onclick = () => popup.remove();

    const message = document.createElement("p");
    message.innerText = "Bạn muốn thực hiện gì?";
    message.style.marginBottom = "20px";

    // Container chứa 2 nút
    const buttonGroup = document.createElement("div");
    buttonGroup.style.cssText = `
        display: flex;
        justify-content: center;
        gap: 20px;
    `;

    const buttonStyle = `
        width: 120px;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        background-color: #fc95c4;
        color: white;
        cursor: pointer;
    `;

    const loginBtn = document.createElement("button");
    loginBtn.innerText = "Đăng nhập";
    loginBtn.style.cssText = buttonStyle;
    loginBtn.onclick = () => { window.location.href = 'includes/login.php'; };

    const signupBtn = document.createElement("button");
    signupBtn.innerText = "Đăng ký";
    signupBtn.style.cssText = buttonStyle;
    signupBtn.onclick = () => { window.location.href = 'includes/signup.php'; };

    // Thêm nút vào nhóm
    buttonGroup.appendChild(loginBtn);
    buttonGroup.appendChild(signupBtn);

    // Thêm các thành phần vào popup
    popupContent.appendChild(closeButton);
    popupContent.appendChild(message);
    popupContent.appendChild(buttonGroup);
    popup.appendChild(popupContent);
    document.body.appendChild(popup);
}

function handleLoginSuccess(username) {
    const userInfo = document.getElementById("user-info");
    userInfo.innerHTML = `
        Xin chào, <strong>${username}</strong> 
    `;
}