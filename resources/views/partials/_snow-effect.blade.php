<div id="snow-container-global"></div>

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
</style>

<script src="https://cdn.jsdelivr.net/npm/tsparticles@3/tsparticles.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles-preset-snow@2/tsparticles.preset.snow.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        (async () => {
            await tsParticles.load({
                id: "snow-container-global",
                options: {
                    background: {
                        color: "transparent"
                    },
                    particles: {
                        number: {
                            value: 250 // tăng số lượng bông tuyết
                        },
                        color: {
                            value: "#FFFFFF" // màu trắng sáng
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
                            }, // nhỏ và tự nhiên
                            random: true
                        },
                        move: {
                            enable: true,
                            speed: 4, // tốc độ rơi
                            direction: "bottom",
                            straight: false,
                            outModes: "out"
                        },
                        shape: {
                            type: "circle" // vẫn giữ dạng tròn
                        }
                    },
                }
            });
        })();
    });
</script>