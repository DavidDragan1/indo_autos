<style>
@import url("https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900&display=swap");

.chat-list-wrap {
    border: 1px solid #E5E5E5;
    margin-right: 1px;
}

@media (max-width: 1200px) {
    .chat-list-wrap {
        margin-bottom: 30px;
    }
}

.chat-list-wrap .chat-list-header {
    padding: 30px 25px;
    border-bottom: 1px solid #e5e5e5;
}

.chat-list-wrap .chat-list-header h3 {
    font-weight: 700;
    font-size: 18px;
    text-transform: uppercase;
    color: #555;
    text-align: center;
    margin-bottom: 15px;
}

.chat-list-wrap .chat-list-header input {
    width: 100%;
    height: 40px;
    padding: 0px 15px;
    border-radius: 5px;
    border: 1px solid #e5e5e5;
}

.chat-list-wrap .chat-list-header input:focus {
    outline: none;
    border-color: #f05c26;
    -webkit-box-shadow: 0 1px 10px rgba(240, 92, 38, 0.3);
    box-shadow: 0 1px 10px rgba(240, 92, 38, 0.3);
}

.chat-list-wrap .chat-list-header input::-webkit-input-placeholder {
    text-transform: capitalize;
}

.chat-list-wrap .chat-list-header input:-ms-input-placeholder {
    text-transform: capitalize;
}

.chat-list-wrap .chat-list-header input::-ms-input-placeholder {
    text-transform: capitalize;
}

.chat-list-wrap .chat-list-header input::placeholder {
    text-transform: capitalize;
}

.chat-list-wrap .scrollbar-inner {
    height: 420px;
}

.chat-list-wrap .chat-list-items .chat-item {
    min-height: 65px;
    padding: 15px 20px;
    border-bottom: 1px solid #e5e5e5;
    overflow: hidden;
    cursor: pointer;
}

@media (max-width: 767px) {
    .chat-list-wrap .chat-list-items .chat-item {
        padding: 10px 15px;
    }
}

.chat-list-wrap .chat-list-items .chat-item.active {
    position: relative;
    z-index: 1;
}

.chat-list-wrap .chat-list-items .chat-item.active::before {
    left: 0;
    top: 0;
    width: 6px;
    height: 100%;
    z-index: 1;
    content: "";
    background: #f05c26;
    position: absolute;
}

.chat-list-wrap .chat-list-items .chat-item:last-child {
    border-bottom: none;
}

.chat-list-wrap .chat-list-items .chat-item .chat-img {
    margin-right: 15px;
    width: 50px;
    min-height: 50px;
    float: left;
    position: relative;
}

@media (max-width: 1200px) {
    .chat-list-wrap .chat-list-items .chat-item .chat-img {
        width: 40px !important;
        min-height: 40px !important;
        margin-right: 10px !important;
    }
}

.chat-list-wrap .chat-list-items .chat-item .chat-img img {
    width: 50px;
    height: 50px;
    -o-object-fit: cover;
    object-fit: cover;
}

@media (max-width: 1200px) {
    .chat-list-wrap .chat-list-items .chat-item .chat-img img {
        width: 40px !important;
        height: 40px !important;
    }
}

.chat-list-wrap .chat-list-items .chat-item .chat-img .online {
    position: absolute;
    right: 0;
    top: 1px;
    width: 12px;
    height: 12px;
    display: block;
    background: #08DD2A;
    border-radius: 50%;
    border: 2px solid #fff;
}

.chat-list-wrap .chat-list-items .chat-item .chat-img .online.offline {
    background: #FFA98A;
}

.chat-list-wrap .chat-list-items .chat-item .chat-content {
    overflow: hidden;
    min-height: 50px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.chat-list-wrap .chat-list-items .chat-item .chat-content p {
    font-size: 16px;
    font-weight: 500;
    color: #555;
    line-height: 20px;
    -webkit-transition: all .4s ease-in-out 0s;
    transition: all .4s ease-in-out 0s;
}

@media (max-width: 1200px) {
    .chat-list-wrap .chat-list-items .chat-item .chat-content p {
        font-size: 14px !important;
    }
}

.chat-list-wrap .chat-list-items .chat-item .chat-content span {
    display: block;
    line-height: 20px;
    font-size: 12px;
    color: #555;
}

.chat-list-wrap .scroll-wrapper .scroll-element.scroll-y {
    right: 0;
}

.chat-list-wrap .scroll-wrapper .scroll-element .scroll-element_outer .scroll-bar {
    opacity: .2;
}

.chat-list-wrap .scroll-wrapper .scroll-element .scroll-element_outer .scroll-element_track {
    opacity: .1;
}

.chat-default-box {
    border-top: 1px solid #e5e5e5;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    min-height: 560px;
    text-align: center;
}

.chat-default-box p {
    font-size: 20px;
    color: #B6B6B6;
    font-weight: 300;
    margin-top: 25px;
}

.chat-box-wrap .chatbox-header {
    border-bottom: 1px solid #e5e5e5;
    padding-bottom: 15px;
    overflow: hidden;
}

.chat-box-wrap .chatbox-header .chatTrigger {
    display: none;
}

@media (max-width: 767px) {
    .chat-box-wrap .chatbox-header {
        background: #fafafa;
        padding: 10px 15px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding-left: 60px;
        position: relative;
    }

    .chat-box-wrap .chatbox-header .chatTrigger {
        display: block;
        position: absolute;
        left: 15px;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        font-size: 24px;
        cursor: pointer;
        -webkit-transition: all .4s ease-in-out 0s;
        transition: all .4s ease-in-out 0s;
    }

    .chat-box-wrap .chatbox-header .chatTrigger:hover {
        color: #f05c26;
    }
}

.chat-box-wrap .chatbox-header .images {
    float: left;
    display: inline-block;
    margin-right: 15px;
}

.chat-box-wrap .chatbox-header .images img {
    display: inline-block;
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.chat-box-wrap .chatbox-header .chatbox-header-content {
    overflow: hidden;
}

.chat-box-wrap .chatbox-header .chatbox-header-content h3 {
    font-weight: 500;
    font-size: 18px;
    color: #555;
    margin-bottom: 0;
}

.chat-box-wrap .chatbox-header .chatbox-header-content span {
    font-weight: 300;
    font-size: 12px;
    line-height: 20px;
    display: block;
    color: #555;
}

.chat-box-wrap .scroll-wrapper .scroll-element.scroll-y {
    right: 0;
}

.chat-box-wrap .scroll-wrapper .scroll-element .scroll-element_outer .scroll-bar {
    opacity: .2;
}

.chat-box-wrap .scroll-wrapper .scroll-element .scroll-element_outer .scroll-element_track {
    opacity: .1;
}

.chat-items {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: 30px 0px;
    height: 400px;
    padding-right: 15px;
}

.chat-items .chat-item {
    width: 100%;
    margin-bottom: 15px;
}

.chat-items .chat-item .chat-item-avatar {
    overflow: hidden;
    margin-bottom: 15px;
}

.chat-items .chat-item .chat-item-avatar .chat-item-img {
    margin-right: 15px;
    float: left;
}

.chat-items .chat-item .chat-item-avatar .chat-item-img img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    -o-object-fit: cover;
    object-fit: cover;
}

.chat-items .chat-item .chat-item-avatar .chat-item-content {
    overflow: hidden;
}

.chat-items .chat-item .chat-item-avatar .chat-item-content span {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: 300;
}

.chat-items .chat-item .chat-item-avatar .chat-item-content span span {
    margin-right: 5px;
    margin-bottom: 0;
    font-weight: 500;
}

.chat-items .chat-item .chat-item-content span {
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: 300;
}

.chat-items .chat-item p {
    min-height: 35px;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    padding: 5px 20px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    font-size: 14px;
    background: #FFDBCE;
    color: #1e1e1e;
    border-radius: 8px;
    max-width: 90%;
    word-break: break-all;
}

.chat-items .chat-item.chat-item-left {
    -webkit-box-pack: start;
    -ms-flex-pack: start;
    justify-content: flex-start;
}

.chat-items .chat-item.chat-item-left p {
    border-top-left-radius: 0px;
    background: #f5f5f5;
}

.chat-items .chat-item.chat-item-right {
    -webkit-box-pack: end;
    -ms-flex-pack: end;
    justify-content: flex-end;
    -ms-flex-wrap: wrap-reverse;
    flex-wrap: wrap-reverse;
    text-align: right;
}

.chat-items .chat-item.chat-item-right span {
    font-weight: 500;
    color: #555;
}

.chat-items .chat-item.chat-item-right p {
    border-bottom-right-radius: 0px;
}

.chat-input {
    padding: 50px 70px 0px;
}

@media (max-width: 767px) {
    .chat-input {
        padding: 30px 0px 0px !important;
    }
}

.chat-input .chat-input-wrap {
    position: relative;
}

.chat-input .chat-input-wrap input {
    background: #fff;
    width: 100%;
    height: 40px;
    border-radius: 30px;
    border: 1px solid #e5e5e5;
    font-size: 14px;
    padding: 0 20px;
    -webkit-transition: all 0.4s ease-in-out 0s;
    transition: all 0.4s ease-in-out 0s;
}

.chat-input .chat-input-wrap input:focus {
    outline: none;
    background: #fff;
    -webkit-box-shadow: 0 1px 10px rgba(240, 92, 38, 0.1);
    box-shadow: 0 1px 10px rgba(240, 92, 38, 0.1);
}

.chat-input .chat-input-wrap input::-webkit-input-placeholder {
    opacity: 1;
    color: #1e1e1e;
}

.chat-input .chat-input-wrap input:-ms-input-placeholder {
    opacity: 1;
    color: #1e1e1e;
}

.chat-input .chat-input-wrap input::-ms-input-placeholder {
    opacity: 1;
    color: #1e1e1e;
}

.chat-input .chat-input-wrap input::placeholder {
    opacity: 1;
    color: #1e1e1e;
}

.chat-input .chat-input-wrap button {
    position: absolute;
    right: 0;
    top: 0;
    width: 60px;
    height: 100%;
    background: #f05c26;
    border: 1px solid #f05c26;
    color: #fff;
    border-radius: 30px;
}

.chat-input .chat-input-wrap button:hover {
    background: #fff;
    color: #f05c26;
}

/*# sourceMappingURL=style.css.map */
</style>