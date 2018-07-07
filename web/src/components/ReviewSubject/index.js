import React, { Component } from 'react';
import { connect } from 'react-redux';

import './index.less';

import { fetchReviewTopic } from '../../assets/fetchApi/action';


const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class ReviewSubject extends Component{
	constructor(props){
		super(props);

		const { token } = props.userInfo;

		this.state = {
			token,
			detail: null,
		}
	}

	componentWillMount(){
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

	render(){
		const { detail } = this.state;

		if(!detail){
			return null;
		}

		return(
			<div className="reviewSubject">
				<div className="reviewSubject-title reviewSubject-field">{detail.title}</div>
				<div className="reviewSubject-body reviewSubject-field">
					<div className="reviewSubject-author">
						<div className="reviewSubject-userImage">
							<img src={detail.user_avatar} alt="" />
						</div>
						<div className="reviewSubject-userName">{detail.user_name}</div>
						<div className="reviewSubject-createTime">{detail.create_time}</div>

						<div className="reviewSubject-count clearfix">
							<span>
								<i className="iconfont icon-liulan2" />
								{detail.view_count}
							</span>
							<span>
								<i className="iconfont icon-weibiaoti-" />
								{detail.good_count}
							</span>
							<span>
								<i className="iconfont icon-pinglun" />
								{detail.reply_count}
							</span>
						</div>


					</div>

					<div className="reviewSubject-content">
						{detail.content}
					</div>
				</div>

				<div className="reviewSubject-reply reviewSubject-field">
					<div className="reviewSubject-reply-title">评论</div>
					
				</div>
			</div>
		)
	}
}

export default ReviewSubject;