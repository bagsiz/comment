<template>
    <div class="comments-app">
        <h1>Comments</h1>
        <div class="comment-form">
            <form class="form" name="form">
                <div class="form-row">
                    <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                    <span class="input" v-if="errorComment" style="color:red">{{errorComment}}</span>
                </div>
                <div class="form-row">
                    <input class="input" placeholder="Username" required v-model="user_name" type="text">
                </div>
                <div class="form-row">
                    <input type="button" class="btn btn-success" @click="saveComment" value="Add Comment">
                </div>
            </form>
        </div>
        <!-- Comments List -->
        <div class="comments" v-if="comments" v-for="(comment,index) in commentsData">
            <!-- Comment -->
            <div class="comment">

                <!-- Comment Box -->
                <div class="comment-box">
                    <div class="comment-text">{{comment.comment}}</div>
                    <div class="comment-footer">
                        <div class="comment-info">
                       <span class="comment-author">
                               <em>{{ comment.user_name}}</em>
                           </span>
                            <span class="comment-date">{{ comment.date}}</span>
                        </div>
                        <div class="comment-actions">
                            <ul class="list">

                                <li>
                                    <a v-on:click="openComment(index)">Reply</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- From -->
                <div class="comment-form comment-v" v-if="commentBoxs[index]">

                    <form class="form" name="form">
                        <div class="form-row">
                            <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                            <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                        </div>
                        <div class="form-row">
                            <input class="input" placeholder="Username" required v-model="user_name"  type="text">
                        </div>
                        <div class="form-row">
                            <input type="button" class="btn btn-success" v-on:click="replyComment(comment.id,index)" value="Add Comment">
                        </div>
                    </form>
                </div>
                <!-- Comment - Reply -->
                <div v-if="comment.replies">
                    <div class="comments" v-for="(replies,index2) in comment.replies">
                        <div v-if="!spamCommentsReply[index2] || !replies.spam" class="comment reply">

                            <!-- Comment Box -->
                            <div class="comment-box" style="background: grey;">
                                <div class="comment-text" style="color: white">{{replies.comment}}</div>
                                <div class="comment-footer">
                                    <div class="comment-info">
                                   <span class="comment-author">
                                           {{replies.user_name}}
                                       </span>
                                        <span class="comment-date">{{replies.date}}</span>
                                    </div>
                                    <div class="comment-actions">
                                        <ul class="list">

                                            <li>
                                                <a v-on:click="replyCommentBox(replies.id)">Reply</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- From -->
                            <div class="comment-form reply" v-if="replyCommentBoxs[replies.id]">

                                <form class="form" name="form">
                                    <div class="form-row">
                                        <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                                        <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                                    </div>
                                    <div class="form-row">
                                        <input class="input" placeholder="Username" required v-model="user_name" type="text">
                                    </div>
                                    <div class="form-row">
                                        <input type="button" class="btn btn-success" v-on:click="replyNestedComment(replies.id, index, index2)" value="Add Comment">
                                    </div>
                                </form>
                            </div>
                            <div v-if="replies.replies">
                                <div class="comments" v-for="(replies,index2) in replies.replies">
                                    <div v-if="!spamCommentsReply[index2] || !replies.spam" class="comment reply">

                                        <!-- Comment Box -->
                                        <div class="comment-box" style="background: grey;">
                                            <div class="comment-text" style="color: white">{{replies.comment}}</div>
                                            <div class="comment-footer">
                                                <div class="comment-info">
                                   <span class="comment-author">
                                           {{replies.user_name}}
                                       </span>
                                                    <span class="comment-date">{{replies.date}}</span>
                                                </div>
                                                <div class="comment-actions">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
var _ = require('lodash');
export default {
    data() {
        return {
            comments: [],
            commentBoxs: [],
            message: null,
            replyCommentBoxs: [],
            commentsData: [],
            viewcomment: [],
            show: [],
            spamCommentsReply: [],
            spamComments: [],
            errorComment: null,
            errorReply: null,
            user_name :null,
            parent_id: 0,
        }
    },
    http: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    methods: {
        fetchComments() {
            this.$http.get('comments/').then(res => {
                this.commentData = res.data;
                this.commentsData = _.orderBy(res.data, ['id'], ['desc']);
                this.comments = 1;
            });

        },
        showComments(index) {
            if (!this.viewcomment[index]) {
                Vue.set(this.show, index, "hide");
                Vue.set(this.viewcomment, index, 1);
            } else {
                Vue.set(this.show, index, "view");
                Vue.set(this.viewcomment, index, 0);
            }
        },
        openComment(index) {
            if (this.commentBoxs[index]) {
                Vue.set(this.commentBoxs, index, 0);
            } else {
                Vue.set(this.commentBoxs, index, 1);
            }
        },
        replyCommentBox(index) {
            if (this.replyCommentBoxs[index]) {
                Vue.set(this.replyCommentBoxs, index, 0);
            } else {
                Vue.set(this.replyCommentBoxs, index, 1);
            }
        },
        saveComment() {
            if (this.message != null && this.message != ' ') {
                this.errorComment = null;
                this.$http.post('comments', {
                    comment: this.message,
                    user_name: this.user_name
                }).then(res => {
                    if (res.status) {
                        this.commentsData.unshift({"id": res.body.id, "user_name": this.user_name, "comment": this.message, "replies": [res.body.replies] });
                        this.message = null;
                        this.user_name = null;
                    }
                });
            } else {
                this.errorComment = "Please enter a comment to save";
            }
        },
        replyComment(commentId, index) {
            if (this.message != null && this.message != ' ') {
                this.errorReply = null;
                this.$http.post('comments', {
                    comment: this.message,
                    user_name: this.user_name,
                    parent_id: commentId,
                }).then(res => {
                    if (res.status) {
                        if (!this.commentsData[index].reply) {
                            this.commentsData[index].replies.unshift({ "id": res.body.id, "user_name": this.user_name, "comment": this.message, "replies": [] });
                            this.commentsData[index].reply = 1;
                            Vue.set(this.replyCommentBoxs, index, 0);
                            Vue.set(this.commentBoxs, index, 0);
                        } else {
                            this.commentsData[index].replies.unshift({ "id": res.body.id, "user_name": this.user_name, "comment": this.message, "replies": [] });
                            Vue.set(this.replyCommentBoxs, index, 0);
                            Vue.set(this.commentBoxs, index, 0);
                        }
                        this.message = null;
                        this.user_name = null;
                    }
                });
            } else {
                this.errorReply = "Please enter a comment to save";
            }
        },
        replyNestedComment(commentId, index, index2) {
            if (this.message != null && this.message != ' ') {
                this.errorReply = null;
                this.$http.post('comments', {
                    comment: this.message,
                    user_name: this.user_name,
                    parent_id: commentId,
                }).then(res => {
                    if (res.status) {
                        console.log(index, index2)
                        console.log('asdsad', this.commentsData[index].replies[index2]);
                        console.log('2222', this.commentsData);
                        this.commentsData[index].replies[index2].replies.unshift({ "id": res.body.id, "user_name": this.user_name, "comment": this.message });
                        this.commentsData[index].reply = 1;
                        Vue.set(this.replyCommentBoxs, index, 0);
                        Vue.set(this.commentBoxs, index, 0);

                        this.message = null;
                        this.user_name = null;
                    }
                });
            } else {
                this.errorReply = "Please enter a comment to save";
            }
        }
    },
    mounted() {
        console.log("mounted");
        this.fetchComments();
    }
}
</script>
