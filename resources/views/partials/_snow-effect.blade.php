<div id="snow-container-global"></div>
<button id="toggle-snow-btn">❄️ Tắt tuyết</button>

<style>
    #snow-container-global {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        pointer-events: none;
        filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.8));
    }

    #toggle-snow-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1001;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    #toggle-snow-btn:hover {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.05);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/tsparticles@3/tsparticles.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles-preset-snow@2/tsparticles.preset.snow.bundle.min.js"></script>
<script>
    // Hàm lưu/đọc cookie
    function setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
    }

    function getCookie(name) {
        const nameEQ = name + '=';
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Đọc trạng thái từ cookie (mặc định là bật)
    let snowEnabled = getCookie('snowEnabled') !== 'false';
    let particlesInstance;

    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('snow-container-global');
        const btn = document.getElementById('toggle-snow-btn');

        // Áp dụng trạng thái đã lưu khi load trang
        if (!snowEnabled) {
            container.style.display = 'none';
            btn.textContent = '❄️ Bật tuyết';
        }

        (async () => {
            particlesInstance = await tsParticles.load({
                id: "snow-container-global",
                options: {
                    background: {
                        color: "transparent"
                    },
                    particles: {
                        number: {
                            value: 250
                        },
                        color: {
                            value: "#FFFFFF"
                        },
                        opacity: {
                            value: 1,
                            animation: {
                                enable: true,
                                speed: 0.3,
                                minimumValue: 0.8
                            }
                        },
                        size: {
                            value: {
                                min: 2,
                                max: 5
                            },
                            random: true
                        },
                        move: {
                            enable: true,
                            speed: 1.5,
                            direction: "bottom",
                            straight: false,
                            outModes: "out"
                        },
                        shape: {
                            type: "circle"
                        }
                    },
                }
            });
        })();

        // Xử lý sự kiện click nút
        btn.addEventListener('click', function() {
            snowEnabled = !snowEnabled;
            
            // Lưu trạng thái vào cookie (tồn tại 30 ngày)
            setCookie('snowEnabled', snowEnabled, 30);
            
            if (snowEnabled) {
                container.style.display = 'block';
                this.textContent = '❄️ Tắt tuyết';
            } else {
                container.style.display = 'none';
                this.textContent = '❄️ Bật tuyết';
            }
        });
    });
</script>