export const isValidUrl = (str: string): boolean => {
    try {
        new URL(str);
        return true;
    } catch {
        return false;
    }
};

export const capitalize = (word: string): string => {
    if (!word) return "";
    return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
};
