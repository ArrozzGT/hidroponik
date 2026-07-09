import * as THREE from 'three';

export function initHero3D(canvasId = 'hero-3d-canvas') {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const scene = new THREE.Scene();
    scene.background = null;

    const container = canvas.parentElement;
    const width = container.clientWidth;
    const height = container.clientHeight;

    const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    camera.position.set(0, 2, 8);
    camera.lookAt(0, 0, 0);

    const renderer = new THREE.WebGLRenderer({
        canvas,
        alpha: true,
        antialias: true,
        powerPreference: 'high-performance',
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.2;

    const ambientLight = new THREE.AmbientLight(0x404040, 0.6);
    scene.add(ambientLight);

    const mainLight = new THREE.DirectionalLight(0xffffff, 1.8);
    mainLight.position.set(5, 10, 5);
    scene.add(mainLight);

    const fillLight = new THREE.DirectionalLight(0x7ED957, 0.4);
    fillLight.position.set(-3, 2, -5);
    scene.add(fillLight);

    const rimLight = new THREE.DirectionalLight(0xE8543E, 0.3);
    rimLight.position.set(-5, 0, 5);
    scene.add(rimLight);

    const produce = {
        lettuce: 0x7ED957,
        tomato: 0xE8543E,
        carrot: 0xF4A340,
        lemon: 0xF2D53C,
        eggplant: 0x5B3A6B,
        basil: 0x2F6B3A,
    };

    const vegGroup = new THREE.Group();
    scene.add(vegGroup);

    function createLettuce() {
        const group = new THREE.Group();
        const leafMat = new THREE.MeshStandardMaterial({
            color: produce.lettuce,
            roughness: 0.6,
            metalness: 0.0,
        });
        const head = new THREE.Mesh(new THREE.SphereGeometry(0.6, 12, 10), leafMat);
        head.scale.set(1, 0.7, 1);
        head.position.y = 0.4;
        group.add(head);
        const leafPositions = [
            [0.5, 0.6, 0.4], [-0.5, 0.6, 0.4], [0.4, 0.6, -0.5], [-0.4, 0.6, -0.5],
            [0, 0.8, 0.6], [0, 0.8, -0.6], [0.6, 0.8, 0], [-0.6, 0.8, 0],
        ];
        leafPositions.forEach(p => {
            const leaf = new THREE.Mesh(new THREE.SphereGeometry(0.25, 8, 8), leafMat);
            leaf.scale.set(1, 0.3, 1);
            leaf.position.set(p[0], p[1], p[2]);
            group.add(leaf);
        });
        const stemMat = new THREE.MeshStandardMaterial({ color: produce.basil, roughness: 0.8 });
        const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.08, 0.4, 6), stemMat);
        stem.position.set(0, -0.1, 0);
        group.add(stem);
        return group;
    }

    function createTomato() {
        const group = new THREE.Group();
        const mat = new THREE.MeshStandardMaterial({
            color: produce.tomato,
            roughness: 0.3,
            metalness: 0.0,
        });
        const body = new THREE.Mesh(new THREE.SphereGeometry(0.4, 12, 10), mat);
        body.scale.set(1, 0.85, 1);
        group.add(body);
        const stemMat = new THREE.MeshStandardMaterial({ color: produce.basil, roughness: 0.8 });
        const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.03, 0.05, 0.15, 6), stemMat);
        stem.position.set(0, 0.4, 0);
        group.add(stem);
        return group;
    }

    function createCarrot() {
        const group = new THREE.Group();
        const mat = new THREE.MeshStandardMaterial({
            color: produce.carrot,
            roughness: 0.5,
            metalness: 0.0,
        });
        const body = new THREE.Mesh(new THREE.ConeGeometry(0.25, 0.9, 8), mat);
        body.position.y = 0.3;
        group.add(body);
        const topMat = new THREE.MeshStandardMaterial({ color: produce.lettuce, roughness: 0.7 });
        const top = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.08, 0.2, 6), topMat);
        top.position.set(0, 0.8, 0);
        group.add(top);
        for (let i = 0; i < 5; i++) {
            const angle = (i / 5) * Math.PI * 2;
            const leaf = new THREE.Mesh(new THREE.PlaneGeometry(0.12, 0.2), new THREE.MeshStandardMaterial({
                color: produce.lettuce, roughness: 0.7, side: THREE.DoubleSide,
            }));
            leaf.position.set(Math.cos(angle) * 0.12, 0.85, Math.sin(angle) * 0.12);
            leaf.rotation.x = -0.3;
            leaf.rotation.z = angle;
            group.add(leaf);
        }
        return group;
    }

    function createLemon() {
        const group = new THREE.Group();
        const mat = new THREE.MeshStandardMaterial({
            color: produce.lemon,
            roughness: 0.3,
            metalness: 0.0,
        });
        const body = new THREE.Mesh(new THREE.SphereGeometry(0.35, 12, 10), mat);
        body.scale.set(1.1, 0.8, 1);
        group.add(body);
        return group;
    }

    function createEggplant() {
        const group = new THREE.Group();
        const mat = new THREE.MeshStandardMaterial({
            color: produce.eggplant,
            roughness: 0.3,
            metalness: 0.1,
        });
        const body = new THREE.Mesh(new THREE.CylinderGeometry(0.15, 0.35, 0.8, 10), mat);
        body.position.y = 0.3;
        group.add(body);
        const capMat = new THREE.MeshStandardMaterial({ color: produce.basil, roughness: 0.8 });
        const cap = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.12, 0.06, 6), capMat);
        cap.position.set(0, 0.75, 0);
        group.add(cap);
        return group;
    }

    const vegetables = [
        { create: createLettuce, pos: [0, 0, 0], scale: 1 },
        { create: createTomato, pos: [1.4, 0.3, 1.2], scale: 0.85 },
        { create: createCarrot, pos: [-1.3, -0.2, 1.3], scale: 0.9 },
        { create: createLemon, pos: [1.5, -0.1, -1.1], scale: 0.8 },
        { create: createEggplant, pos: [-1.4, 0.2, -1.2], scale: 0.85 },
    ];

    const vegObjects = vegetables.map((v, i) => {
        const obj = v.create();
        obj.position.set(v.pos[0], v.pos[1], v.pos[2]);
        obj.scale.set(v.scale, v.scale, v.scale);
        obj.userData = {
            baseY: v.pos[1],
            phase: i * 1.2,
            rotSpeed: 0.003 + i * 0.001,
            bobSpeed: 0.4 + i * 0.1,
            bobHeight: 0.08 + i * 0.02,
            orbitRadius: Math.sqrt(v.pos[0] ** 2 + v.pos[2] ** 2),
            orbitAngle: Math.atan2(v.pos[2], v.pos[0]),
        };
        vegGroup.add(obj);
        return obj;
    });

    const groundMat = new THREE.MeshStandardMaterial({
        color: 0x0B1710,
        roughness: 1,
        metalness: 0,
        transparent: true,
        opacity: 0.0,
    });
    const ground = new THREE.Mesh(new THREE.CircleGeometry(6, 16), groundMat);
    ground.rotation.x = -Math.PI / 2;
    ground.position.y = -0.5;
    scene.add(ground);

    let mouseX = 0;
    let mouseY = 0;
    let targetMouseX = 0;
    let targetMouseY = 0;

    let mouseHandler = null;
    let touchHandler = null;

    if (!reducedMotion) {
        mouseHandler = (e) => {
            const rect = container.getBoundingClientRect();
            targetMouseX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
            targetMouseY = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        };
        document.addEventListener('mousemove', mouseHandler, { passive: true });

        touchHandler = (e) => {
            const touch = e.touches[0];
            const rect = container.getBoundingClientRect();
            targetMouseX = ((touch.clientX - rect.left) / rect.width - 0.5) * 2;
            targetMouseY = ((touch.clientY - rect.top) / rect.height - 0.5) * 2;
        };
        container.addEventListener('touchmove', touchHandler, { passive: true });
    }

    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);
        const elapsed = clock.getElapsedTime();

        mouseX += (targetMouseX - mouseX) * 0.05;
        mouseY += (targetMouseY - mouseY) * 0.05;

        if (!reducedMotion) {
            vegGroup.rotation.y = elapsed * 0.08 + mouseX * 0.3;
            vegGroup.rotation.x = mouseY * 0.15;

            vegObjects.forEach((obj, i) => {
                const data = obj.userData;
                const yOffset = Math.sin(elapsed * data.bobSpeed + data.phase) * data.bobHeight;
                obj.position.y = data.baseY + yOffset;
                obj.rotation.y += data.rotSpeed;
                obj.rotation.x = Math.sin(elapsed * 0.2 + data.phase) * 0.05;
            });

            camera.position.x = mouseX * 0.5;
            camera.position.y = 2 + mouseY * 0.3;
            camera.lookAt(0, 0.2, 0);
        }

        renderer.render(scene, camera);
    }

    animate();

    function handleResize() {
        const w = container.clientWidth;
        const h = container.clientHeight;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
    }

    window.addEventListener('resize', handleResize);

    // Hide loading indicator
    const loadingEl = document.getElementById('hero-3d-loading');
    if (loadingEl) loadingEl.style.display = 'none';

    return () => {
        window.removeEventListener('resize', handleResize);
        if (mouseHandler) document.removeEventListener('mousemove', mouseHandler);
        if (touchHandler) container.removeEventListener('touchmove', touchHandler);
        renderer.dispose();
        scene.clear();
        if (loadingEl) loadingEl.remove();
    };
}
