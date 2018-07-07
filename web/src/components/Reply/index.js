/** 
 * 回复主题
 */ 

import React, { Component } from 'react';
import { connect } from 'react-redux';
import './index.less';

import { 
	fetchReviewTopic, 
	fetchReplyTopic, 
} from '../../assets/fetchApi/action';

const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class Reply extends Component{
	constructor(props){
		super(props);

		const { token } = props.userInfo;

		this.state = {
			token,
			detail: null,
			reply: '',
		}

		this.setReply = this.setReply.bind(this);
		this.onReply = this.onReply.bind(this);
	}

	componentDidMount(){
		const { params } = this.props;
		const { token } = this.state;

		fetchReviewTopic({
			topic_id: params.id,
			token,
		})
			.then(res => {
				console.log(res);
				this.setState({
					detail: res.data,
				})
			});
	}

	setReply(e){
		this.setState({
			reply: e.target.value,
		});
	}

	onReply(e){
		e.preventDefault();

		const { params, router } = this.props;
		const { reply, token } = this.state;
		if(reply === ''){
			return;
		}

		fetchReplyTopic({
			token,
			topic_id: params.id,
			content: reply,
		}).then(res => {
			router.goBack();
		});
	}

	render(){
		const { reply, detail } = this.state;
		let title = '';
		if(detail){
			title = detail.title;
		}

		return (
			<form className="reply" onSubmit={this.onReply}>
				<div className="reply-target">{title}</div>
				<div className="reply-content">
					<textarea
						placeholder="填写回答内容"
						value={reply}
						onChange={this.setReply}
						rows={10} />
				</div>
				<div className="reply-tools">
					<button 
						type="submit" 
						className="reply-btn-submit" 
						children="回复" />
				</div>
			</form>
		)
	}
}

export default Reply;