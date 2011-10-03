<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Animation - 3D WebGL Short interactive movie</title>
		<link type="text/css" rel="stylesheet" href="css/screen.css"/>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript" src="js/lib/Three.js"></script>
		<script type="text/javascript" src="js/lib/DAT.GUI.min.js"></script>
	</head>
	
	<body>
		<h1>Three JS Test</h1>
		<div id="container"></div>
		
		<script type="text/javascript">
			// set the scene size
			var WIDTH = 640,
				HEIGHT = 480;

			// set some camera attributes
			var VIEW_ANGLE = 45,
				ASPECT = WIDTH / HEIGHT,
				NEAR = 0.1,
				FAR = 10000;

			// get the DOM element to attach to
			// - assume we've got jQuery to hand
			var $container = $('#container');

			// create a WebGL renderer, camera
			// and a scene
			var renderer = new THREE.WebGLRenderer({ antialias : true });
			var camera = new THREE.Camera( VIEW_ANGLE, ASPECT, NEAR, FAR );
			/*
			var camera = new THREE.FirstPersonCamera( {
				fov : VIEW_ANGLE, 
				aspect : ASPECT, 
				near : NEAR, 
				far : FAR,
				movementSpeed : 100.0,
				noFly  : true
			});
			*/
			
			var scene = new THREE.Scene();
			
			
			// set up the sphere vars
			var radius = 40, segments = 8, rings = 8;

			var sphereMaterial = new THREE.MeshLambertMaterial({ 
				color: 0xaaaaaa,
				shading : THREE.FlatShading
			});
			
			var cubeMaterial = new THREE.MeshLambertMaterial({ 
				color: 0x333333
			});
			
			// create a new mesh with sphere geometry -
			// we will cover the sphereMaterial next!
			var sphere = new THREE.Mesh( new THREE.SphereGeometry(radius, segments, rings), sphereMaterial);
			
			var cubeSize = 1000;
			var cube = new THREE.Mesh( new THREE.CubeGeometry(cubeSize, cubeSize, cubeSize, 50, 50, 50, undefined, true), cubeMaterial );
			
			// add a ground plane
			var planeGeo = new THREE.PlaneGeometry(400, 200, 10, 10);
			var planeMat = new THREE.MeshLambertMaterial({color: 0xFFFFFF});
			var plane = new THREE.Mesh(planeGeo, planeMat);
			
			plane.rotation.x = -Math.PI/2;
			plane.position.y = 0;
			plane.receiveShadow = true;
			
			// create a point light
			//var pointLight = new THREE.PointLight( 0xffffff, 0.4 );
			var pointLight = new THREE.SpotLight();
			pointLight.position.set( 170, 330, -160 );
			
			var ambiantLight = new THREE.AmbientLight( 0x999999 );

			$(window).load(function(){
				
				// the camera starts at 0,0,0 so pull it back
				camera.position.x = 400;
				camera.position.y = 400;
				camera.position.z = 400;

				// start the renderer
				renderer.setSize(WIDTH, HEIGHT);

				// attach the render-supplied DOM element
				$container.append(renderer.domElement);
				
				// add the sphere to the scene
				scene.addChild(sphere);
				scene.addChild(cube);
				scene.addChild(plane);
				
				// set mesh position
				cube.position.y = 200;
				sphere.position.y = 50;

				// set pointlight position
				/*
				pointLight.position.x = 100;
				pointLight.position.y = 100;
				pointLight.position.z = 100;
				*/

				// add to the scene
				scene.addLight(pointLight);
				scene.addLight(ambiantLight);
				
				// enable shadows on the renderer
				renderer.shadowMapEnabled = true;

				// enable shadows for a light
				pointLight.castShadow = true;

				// enable shadows for an object
				sphere.castShadow = true;
				sphere.receiveShadow = true;
				
				renderer.render(scene, camera);
				
				animate(new Date().getTime());
				
				
				// MOUSE MOVEMENT HANDLER
				$container = $("#container canvas");
				var down = false;
				var sx = 0, sy = 0;
				$container.mousedown(function (ev){
					down = true; 
					sx = ev.clientX; 
					sy = ev.clientY;
				});
				$container.mouseup(function(){ 
					down = false; 
				});
				$container.mousemove(function(ev) {
					if (down) {
						var dx = ev.clientX - sx;
						var dy = ev.clientY - sy;
						camera.position.x += dx;
						camera.position.y += dy;
						sx += dx;
						sy += dy;
					}
				});
			});
			
			function animate(t) {
				
				// spin the camera in a circle
				// camera.position.x = Math.sin(t/1000)*300;
				// camera.position.y = 150;
				// camera.position.z = Math.cos(t/1000)*300;
				sphere.rotation.y += .02;
				sphere.rotation.z += .02;
				
				// renderer automatically clears unless autoClear = false
				renderer.render(scene, camera);
				window.webkitRequestAnimationFrame(animate, renderer.domElement);
			};
			
			var gui = new DAT.GUI();
			gui.add(sphere.position, 'x').min(-500).max(500).step(10);
			gui.add(sphere.position, 'y', -500, 500, 10);
			gui.add(sphere.position, 'z', -500, 500, 10);
		</script>
		
	</body>
	
</html>