import React, { Component } from 'react';
import { connect } from 'react-redux';
import classnames from 'classnames';

import './index.less';

import { 
	fetchReviewTopic, 
	fetchToggleLike, 
	fetchToggleCollect 
} from '../../assets/fetchApi/action';


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

		this.like = this.like.bind(this);
		this.collect = this.collect.bind(this);
		this.reply = this.reply.bind(this);
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
	// 点赞
	like(){
		console.log('点赞了...');
		const { params } = this.props;
		const { is_good } = this.state.detail;
		const { token } = this.state;

		fetchToggleLike(is_good, params.id, token)
			.then(res => {
				console.log(res);
			});
	}
	// 收藏
	collect(){
		console.log('收藏了...');
		const { params } = this.props;
		const { token } = this.state;

		fetchToggleCollect(0, params.id, token)
			.then(res => {
				console.log(res);
			})
	}
	// 回复跳转
	reply(){
		const { params, router } = this.props;

		router.push(`/subject/reply/${params.id}`);
	}	

	render(){
		const { detail } = this.state;

		if(!detail){
			return null;
		}

		const { is_good } = detail;

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
							<span className={{}}>
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

				<div className="reviewSubject-tools">
					<span onClick={this.like} className={classnames({is_good: is_good !== 0})}>
						<i className="iconfont icon-zan" />
						赞·{detail.good_count}
					</span>
					<span onClick={this.collect}>
						<i className="iconfont icon-shoucang" />
						收藏
					</span>
					<span onClick={this.reply}>
						<i className="iconfont icon-pinglun" />
						评论
					</span>
				</div>
			</div>
		)
	}
}

export default ReviewSubject;