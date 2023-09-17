class Path {

    constructor(htmlObj, laserSize){

        this.htmlObj = htmlObj;
        
        this.length = htmlObj.getTotalLength();

        this.laserSize = laserSize;

        htmlObj.setAttribute("stroke-dasharray", laserSize + " " + this.length);
        htmlObj.setAttribute("stroke-dashoffset", laserSize);

    }

}


class PathAnimation{

    move(u, paths){

        for(let i = 0; i < paths.length; ++i){
    
            let distance = paths[i].laserSize - (u[i] * (paths[i].length + paths[i].laserSize));
    
            paths[i].htmlObj.setAttribute("stroke-dashoffset", distance);
    
        }
    
    }
    
    run(duration, startTime, paths){
    
        let u = [];
    
        for(let i = 0; i < paths.length; i++){
    
            duration = paths[i].length  / paths[0].length  * 1000;
    
            let distancePassed = Math.min((Date.now() - startTime) / duration, 1);
    
            u.push(distancePassed);        
    
        }
    
    
        if(u[paths.length - 1] < 1){
            requestAnimationFrame(() => this.run(duration, startTime, paths));
        }
        else{
    
            startTime = Date.now();
            this.run(duration, startTime, paths);
    
        }
    
        this.move(u, paths);
    
    }
    
    animate(duration, htmlPaths, laserSize){
    
        let paths = [];
    
        htmlPaths.forEach(htmlPath => {
            paths.push(new Path(htmlPath, laserSize));
        });
        
    
        this.run(duration, Date.now(), paths);
    }

}

class RotatingImageAnimation{

    angleToRotate = [];

    imagesPositions = [];

    isCompleted = true;

    changeZIndex(htmlObj, zIndex){
        htmlObj.style.zIndex =  zIndex;
    }

    rotate(htmlObj, angle){
        htmlObj.style.transform = "rotate(" + angle + "deg)";
    }

    move(animationCompleted, htmlImages){

        animationCompleted = -(Math.cos(Math.PI * animationCompleted) - 1) / 2;
    
        for(let i = 0; i < this.imagesPositions.length; ++i ){

            let rotation = 0;            
            
            if(i == 0){
                rotation = animationCompleted * this.angleToRotate[0];
                this.rotate(htmlImages[this.imagesPositions[i]], rotation);
                
            }else{
                rotation = (360 - i * 10) + animationCompleted * this.angleToRotate[1]
                this.rotate(htmlImages[this.imagesPositions[i]], rotation);

            }
            
        }


        
    }

    run(duration, startTime, htmlImages){


        let animationCompleted = Math.min((Date.now() - startTime) / duration, 1)


        if(animationCompleted < 1){
            requestAnimationFrame(() => this.run(duration, startTime, htmlImages));
        }
        
        if(animationCompleted >= 1){
            
            this.imagesPositions = this.nextImagesPositions.slice(0);

            this.isCompleted = true;

            return;

        }

        if(animationCompleted >= 0.5 && !this.isZChanged){

            for(let i = 0; i < this.nextImagesPositions.length; ++i){

                if(i == 0){
                    this.changeZIndex(htmlImages[this.nextImagesPositions[i]], this.nextImagesPositions.length * 10);
                }
                else{
                    this.changeZIndex(htmlImages[this.nextImagesPositions[i]], (this.nextImagesPositions.length - i) * 10);

                }

            }

            this.isZChanged = true;

        }

        this.move(animationCompleted, htmlImages)


    }

    animate(duration, htmlImages){

        if(this.isCompleted){

            if(this.imagesPositions.length == 0){
                for(let i = 0; i < htmlImages.length; ++i){
                    this.imagesPositions.push(i);
                }
            }

            if(this.angleToRotate.length == 0){
                this.angleToRotate = [360 - (this.imagesPositions.length - 1) * 10, 10];
            }

            this.isZChanged = false;
    
            this.isCompleted = false;

            this.nextImagesPositions = this.imagesPositions.slice(0);
    
            let temp = this.nextImagesPositions[0];
    
            for(let i = 0; i < this.nextImagesPositions.length; ++i){
                
                if(i > (this.nextImagesPositions.length - 2)) break;
    
                this.nextImagesPositions[i] = this.nextImagesPositions[i + 1];
    
            }
    
            this.nextImagesPositions[this.nextImagesPositions.length - 1] = temp
    
    
            this.run(duration, Date.now(), htmlImages)

        }
        
    }
}

class HorizontalImageAnimation{

    halfWidth = null;

    halfHeight = null;

    side = ""

    imageIndex = 1;

    isCompleted = true;

    move(animationCompleted, htmlCurrentImage, nextImage){


        if(this.side == "l"){

            let currentImageMovementProcentage = 50 - 50 * animationCompleted;
            let nextImageMovementProcentage = 100 - 50 * animationCompleted;

            let currentImageMovementOffset = -this.halfWidth - this.halfWidth * animationCompleted;
            let nextImageMovementOffset = -this.halfWidth * animationCompleted;

            htmlCurrentImage.style.left = currentImageMovementProcentage + "%";
            htmlCurrentImage.style.marginLeft = currentImageMovementOffset + "px";
    
            nextImage.style.left = nextImageMovementProcentage + "%";
            nextImage.style.marginLeft = nextImageMovementOffset + "px";

        }

        if(this.side == "r"){

            let currentImageMovementProcentage = 50 + 50 * animationCompleted;
            let nextImageMovementProcentage = 50 * animationCompleted;

            let currentImageMovementOffset = -this.halfWidth + this.halfWidth * animationCompleted;
            let nextImageMovementOffset = -(this.halfWidth * 2) + this.halfWidth * animationCompleted;

            htmlCurrentImage.style.left = currentImageMovementProcentage + "%";
            htmlCurrentImage.style.marginLeft = currentImageMovementOffset + "px";
    
            nextImage.style.left = nextImageMovementProcentage + "%";
            nextImage.style.marginLeft = nextImageMovementOffset + "px";

        }



    }

    run(duration, startTime, htmlCurrentImage, nextImage){

        let animationCompleted = Math.min((Date.now() - startTime) / duration, 1);

        animationCompleted = -(Math.cos(Math.PI * animationCompleted) - 1) / 2;

        if(animationCompleted < 1){
            requestAnimationFrame(() => this.run(duration, startTime, htmlCurrentImage, nextImage));
        }else {
            this.isCompleted = true;
            htmlCurrentImage.remove();
        }

        this.move(animationCompleted, htmlCurrentImage, nextImage);

    }

    animate(duration, side){

        if(!this.isCompleted) return;

        this.side = side;
        this.isCompleted = false;


        let htmlCurrentImage = document.querySelector(".php-section .wrapper .images-container img");


        if(this.halfWidth == null){

            let style = window.getComputedStyle(htmlCurrentImage);

            this.halfWidth = parseInt(style.width) / 2;
            this.halfHeight = parseInt(style.height) / 2;

        }




        let imagesContainer  = document.querySelector(".php-section .wrapper .images-container"); 
        
        this.imageIndex++;

        if(this.imageIndex == 7){
            this.imageIndex = 1;
        }

        let nextImage = document.createElement("img");

        


        nextImage.setAttribute("src", "images/non-vector/php" + this.imageIndex +".png");
        nextImage.setAttribute("alt", "php example image");

        if(this.side == "l"){
            nextImage.style.left = "100%";
            nextImage.style.marginLeft = "0";
        }
        
        if(this.side == "r"){

            nextImage.style.left = "0%"         
            nextImage.style.marginLeft = "-378px";
        }


        imagesContainer.appendChild(nextImage);

        this.run(duration, Date.now(), htmlCurrentImage, nextImage);



    }

}

class FadeAnimation {

    move(animationCompleted, htmlElement){

        htmlElement.style.opacity = 1 - 1 * animationCompleted;

    }

    run(duration, startTime, htmlElement){

        let animationCompleted = Math.min((Date.now() - startTime) / duration, 1);

        console.log(animationCompleted);
        if(animationCompleted < 1){
            requestAnimationFrame(() => this.run(duration, startTime, htmlElement));
        }
        else{
            htmlElement.remove();
        }

        this.move(animationCompleted, htmlElement);

    }

    animate(duration, htmlElement){
        this.run(duration, Date.now(), htmlElement);
    }
}

let cornerLinesAnimation = new PathAnimation();
let iconLinesAnimation = new PathAnimation();
let imagesRotationAnimation = new RotatingImageAnimation();
let imagesHorizontalAnimation = new HorizontalImageAnimation();
let emailMessageFade = new FadeAnimation();

let htmlCornerPaths = Array.from(document.getElementsByClassName('corner-line'));
let htmlImages = Array.from(document.getElementsByClassName("rotating-card"));
let htmlIconPaths = Array.from(document.getElementsByClassName("icon-lines"));
let emailMessage = document.querySelector(".header-section .email-container");

cornerLinesAnimation.animate(500, htmlCornerPaths, 40);
iconLinesAnimation.animate(1000, htmlIconPaths, 80)

const arrow = document.getElementById("image-arrow");
const leftArrow = document.getElementById("left-arrow");
const rightArrow = document.getElementById("right-arrow");


if(emailMessage != null){
    setTimeout(function() {
        emailMessageFade.animate(3000, emailMessage);
    }, 2000);
}

arrow.addEventListener("click", function(){

    imagesRotationAnimation.animate(1000, htmlImages);

});

leftArrow.addEventListener('click', function(){

    imagesHorizontalAnimation.animate(700, "l");

});

rightArrow.addEventListener('click', function(){

    imagesHorizontalAnimation.animate(700, "r");

});

    
