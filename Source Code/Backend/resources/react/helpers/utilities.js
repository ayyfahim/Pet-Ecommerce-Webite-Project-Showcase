export const validationErrorExtraction = errors => {
    return errors
        .map(single => ({ path: single.path, errors: single.errors }))
        .reduce((obj, item) => {
            obj[item.path] = item.errors;
            return obj;
        }, {});
};

export const addToLocalStorage = (key, value, cb = null) => {
    localStorage.setItem(key, JSON.stringify(value));
    if (cb && typeof cb === "function") {
        return cb();
    }
    return false;
};

export const removeFromLocalStorage = (key, cb = null) => {
    localStorage.removeItem(key);
    if (cb && typeof cb === "function") {
        return cb();
    }
    return false;
};

export const readFromLocalStorage = (key, cb = null) => {
    const data = localStorage.getItem(key);
    if (cb && typeof cb === "function") {
        return cb(JSON.parse(data));
    }
    return JSON.parse(data);
};

export const expiryDateRemaining = date => {
    const second = 1000;
    const minute = second * 60;
    const hour = minute * 60;
    const distance = date - new Date().getTime();

    if (distance < 0) {
        return false;
    }

    return { h: Math.floor(distance / hour), m: Math.floor((distance % hour) / minute), s: Math.floor((distance % minute) / second) };
};
