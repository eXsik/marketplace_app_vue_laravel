export const listingImageUrl = (image) => {
    if (!image) return '/images/listing-placeholder.svg';
    if (image.startsWith('http://') || image.startsWith('https://'))
        return image;
    if (image.startsWith('demo/')) return `/images/${image}`;
    if (image.startsWith('/')) return image;
    return `/storage/${image}`;
};
