        import {GLTFLoader} from './GLTFLoader.js';
        import {OrbitControls} from './OrbitControls.js';

        var obj;
        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(
            45,
            window.innerWidth/window.innerHeight,
            1,
            1000
        );
        
        var renderer = new THREE.WebGLRenderer( { alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        var controls = new OrbitControls( camera, renderer.domElement );
        controls.addEventListener('change', renderer);
        controls.enableZoom = false;
        controls.enableDamping = true;
        controls.enablePan = false;
        //Window Resize Control
        window.addEventListener( 'resize', onWindowResize, false );

        function onWindowResize(){
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize( window.innerWidth, window.innerHeight );
        }
        //Window Resize Control

        $('.canvas-area').append(renderer.domElement);
        $('.canvas-area').find('canvas').attr('id', 'canvas3d').addClass('min-vh-100');
        
        var loader = new GLTFLoader();
        
        loader.load("assets/frontend/3d/spyd.glb", function(gltf){
            obj = gltf.scene;
            obj.rotation.x = 0.6;
            obj.rotation.y = 3;
            obj.rotation.z = 0.2;
            obj.scale.set(1.3,1.3,1.3);
            scene.add(obj);
        });

        // scene.background = new THREE.Color(0x222222, 0);
        renderer.setClearColor( 0x000000, 0 ); // the default

        var light = new THREE.HemisphereLight(0xffffff, 0x00029e, 2);

        const light1 = new THREE.DirectionalLight(0xFF0000, 1);
        light1.position.set(0, 0, 0);

        const light2 = new THREE.DirectionalLight(0xFF0000, 1);
        light2.position.set(-10, 4, -10);

        const light3 = new THREE.DirectionalLight(0xFF0000, 1);
        light3.position.set(10, 4, 10);

        scene.add(light);
        scene.add(light1);
        scene.add(light2);
        scene.add(light3);

        camera.position.set(0, -1, 10);
        controls.target.set(0, -1, 0);

        function animate(){
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
            obj.rotation.y -= 0.01;
            // controls.autoRotate = true;
            // controls.update();
        }
        animate();
