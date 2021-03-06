import Api from '../api';

export default {
    data() {
        return {
            formUrl: null,
            backUrl: null,
            buttonDisabled: false,
            errors: {},
        };
    },
    methods: {
        save() {
            const client = Api.client();
            let method, url;

            if (this.isNew()) {
                method = client.post;
                url = this.formUrl;
            } else {
                method = client.patch;
                url = this.formUrl + '/' + this.form.id;
            }
            let data = Object.assign({}, this.form);
            delete data['id'];

            return method(url, data).then(() => {
                this.errors = {};
                this.$router.push(this.backUrl);
            }).catch(this.processError);
        },
        remove() {
            if (!confirm('Are you sure?')) {
                return;
            }

            return Api.client().delete(this.formUrl + '/' + this.form.id).then(() => {
                this.errors = {};
                this.$router.push(this.backUrl);
            }).catch(this.processError);
        },
        isNew() {
            return this.form.id === 'new';
        },
        onSubmit(evt) {
            evt.preventDefault();
            this.buttonDisabled = true;
            this.save();
        },
        getFieldState(field) {
            if (this.errors[field] && this.errors[field].length > 0) {
                return false;
            }
            return null;
        },
        getFieldError(field) {
            if (this.errors[field] && this.errors[field].length > 0) {
                return this.errors[field].join("\r\n");
            }
            return null;
        },
        processError(error) {
            this.buttonDisabled = false;

            if (error.response && error.response.data) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                    return;
                }
                return console.error(error.response);

            }
            throw error;
        }
    }
}