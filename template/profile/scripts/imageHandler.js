const profilePicture = document.querySelector('.profile-picture');
const profileInput = document.querySelector('.profile-input');
const profileImage = document.querySelector('.profile-image');

profileInput.addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.addEventListener('load', function () {
      const image = new Image();
      image.src = reader.result;
      image.onload = function () {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const maxWidth = 800;
        const maxHeight = 800;
        let width = image.width;
        let height = image.height;
        if (width > maxWidth || height > maxHeight) {
          if (width > height) {
            height *= maxWidth / width;
            width = maxWidth;
          } else {
            width *= maxHeight / height;
            height = maxHeight;
          }
        }
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(image, 0, 0, width, height);
        const compressedImage = canvas.toDataURL('image/jpeg', 0.7);
        profileImage.src = compressedImage;
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'imageBase64';
        hiddenInput.value = compressedImage;
        let formA = document.getElementById('profile-form');
        formA.appendChild(hiddenInput);
      };
    });
    reader.readAsDataURL(file);
  }
});
