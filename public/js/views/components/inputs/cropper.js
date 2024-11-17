const inputImage = document.querySelector('.input-image');
const imagePreview = document.querySelector('.image-preview');
const cropperModal = document.getElementById('cropper-modal');
const cropperModalContent = document.getElementById('cropper-modal-content');
const cropperPreview = cropperModalContent.querySelector('.cropper-preview');
const body = document.querySelector('body');


inputImage.addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){            
            cropperPreview.src = e.target.result;
            openCropperModal(file);
        }
        reader.readAsDataURL(file);
    }
})


function openCropperModal(file){
    cropperModal.classList.replace('hidden', 'flex');
    setTimeout(() => {
        cropperModal.classList.replace('opacity-0', 'opacity-100');
        cropperModalContent.classList.replace('scale-0', 'scale-100');
        body.classList.remove('overflow-y-scroll');
        body.classList.add('overflow-y-hidden', 'pr-[10px]');
    }, 100);

    const cropper = new Cropper(cropperPreview, {
        aspectRatio: 1,
        viewMode: 1,
        zoomable: false,
    });

    const cropButton = cropperModalContent.querySelector('.crop-button');
    function handleCrop(e){
        e.stopPropagation();
        const canvas = cropper.getCroppedCanvas();
        cropImage(canvas, file);
        closeCropperModal(() => {
            cropButton.removeEventListener('click', handleCrop);
            document.removeEventListener('click', handleClickOutside);
            cropper.destroy();
        });
    }
    cropButton.addEventListener('click', handleCrop);

    const cancelButton = cropperModalContent.querySelector('.cancel-button');
    function handleCancel(e){
        e.stopPropagation();
        closeCropperModal(() => {
            cancelButton.removeEventListener('click', handleCancel);
            document.removeEventListener('click', handleClickOutside);
            cropper.destroy();
        });
    }
    cancelButton.addEventListener('click', handleCancel);

    function handleClickOutside(e){
        if(!cropperModalContent.contains(e.target)){
            closeCropperModal(() => {
                cancelButton.removeEventListener('click', handleCancel);
                document.removeEventListener('click', handleClickOutside);
                cropper.destroy();
            });
        }
    }
    document.addEventListener('click', handleClickOutside);
}

function closeCropperModal(callback){
    const cropperModalContent = document.getElementById('cropper-modal-content');
    const cropperModal = document.getElementById('cropper-modal');
    const body = document.querySelector('body');

    cropperModalContent.classList.replace('scale-100', 'scale-0');
    cropperModal.classList.replace('opacity-100', 'opacity-0');

    cropperModalContent.addEventListener('transitionend', () => {
        cropperModal.classList.replace('flex', 'hidden');
        body.classList.remove('overflow-y-hidden', 'pr-[10px]');
        body.classList.add('overflow-y-scroll');
    }, {once: true});
    
    callback();
}

function cropImage(canvas, file){
    canvas.toBlob((blob) => {
        const newFile = new File([blob], file.name, {type: file.type});
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(newFile);
        inputImage.files = dataTransfer.files;
        const reader = new FileReader();
        reader.onload = function(e){
            imagePreview.src = e.target.result;
        }
        reader.readAsDataURL(newFile);
    });
}