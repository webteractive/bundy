String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1)
}

String.prototype.getInitials = function (glue) {
    if (typeof glue == "undefined") {
        var glue = true;
    }

    let initials = this.replace(/[^a-zA-Z- ]/g, "").match(/\b\w/g);

    if (glue) {
        return initials.join('');
    }

    return  initials;
};

String.prototype.toComponent = function () {
    return this.replace(/_/g, '-');
}