import React, { Component } from 'react';
import { connect } from 'react-redux';
import './index.less';
import { Link } from 'react-router';

import { fetchGetUserReply } from '../../assets/fetchApi/action';

const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class ReplyList extends Component{
	constructor(props){
		super(props);

		this.state = {
			list: [],
		};
	}

	componentDidMount(){
		const { userInfo } = this.props;

		fetchGetUserReply(userInfo.token)
			.then(res => {
				this.setState({
					list: res.data,
				})
			})
	}


	render(){
		const { list } = this.state;

		return (
			<div className="replyList">
				{
					list.map(reply => 
						<Link key={reply.reply_id} 
									className="replyList-item" 
									to={`/subject/review/${reply.topic_id}`}>
							<div className="replyList-user">
								<div className="replyList-user-avatar">
									<img src={reply.user_avatar} alt="" />
								</div>
								<div className="replyList-user-name">{reply.user_name}</div>
								<div className="replyList-user-time">{reply.create_time}</div>
							</div>
							<div className="replyList-content">{reply.content}</div>
							<div className="replyList-title">{reply.title}</div>
						</Link>
					)
				}
			</div>
		)
	}
}

export default ReplyList;