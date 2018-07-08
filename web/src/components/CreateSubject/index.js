import React, { Component } from 'react';
import { connect } from 'react-redux';
import { tabs } from '../Square/config';
import fieldsetInit from '../decorators/fieldsetInit';
import { fetchCreateTopic } from '../../assets/fetchApi/action';

import classnames from 'classnames';
import './index.less';

import { 
	showLoading, 
	hideLoading, 
	showToast, 
	hideToast, 
} from '../common/Loading/loadingRedux';

const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@fieldsetInit({
	title: '',
	content: '',
	topic_type: '',
	// 图片需要单独处理
	// images_list: [],
})
@connect(mapStateToProps)
class CreateSubject extends Component{
	constructor(props){
		super(props);

		const { userInfo, location } = props;
		let offer_award_id = '';
		if(location.query && location.query.award){
			offer_award_id = location.query.award;
		}

		this.state = {
			token: userInfo.token,
			offer_award_id,
		}
		this.onSubmit = this.onSubmit.bind(this);
	}

	onSubmit(e){
		e.preventDefault();

		const {
			title,
			content,
			topic_type,

			router,
			dispatch,
		} = this.props;
		const { token, offer_award_id } = this.state;

		if(!title || !content || !topic_type){
			return;
		}
		dispatch(showLoading());

		fetchCreateTopic({
			token,
			title,
			content,
			topic_type,
			offer_award_id,
		}).then(res => {
			dispatch(hideLoading());
			dispatch(showToast('发布成功'));
			const { topic_id } = res.data;

			router.push(`/subject/review/${topic_id}`);
			setTimeout(() => {
				dispatch(hideToast('已采纳'));
			}, 2000);
		});
	}

	render(){
		const { 
			title,
			content,
			topic_type,

			set_title,
			set_content,
			set_topic_type,
		} = this.props;

		return(
			<div className="createSubject">
				<form onSubmit={this.onSubmit}>
					<div className="createSubject-field">
						<textarea 
							maxLength="60"
							placeholder="填写主题"
							onChange={set_title}
							value={title} />
					</div>
					<div className="createSubject-field">
						<textarea 
							rows="5"
							placeholder="说说你的心得或问题吧~"
							onChange={set_content}
							value={content} />
					</div>

					<div className="createSubject-field">
						<span>栏目</span>
						{
							tabs.map(item => 
								<label 
									className={classnames('createSubject-radio', {checked: topic_type === item.topic_type})} 
									key={item.topic_type}>
									<input 
										type="radio" 
										value={item.topic_type} 
										checked={topic_type === item.topic_type} 
										onChange={set_topic_type} />
									{item.topic_type_name}
								</label>
							)
						}
					</div>

					<div className="createSubject-tools">
						<button 
							type="submit" 
							className="createSubject-btn-submit" 
							children="发布" />
					</div>
				</form>
			</div>
		)
	}
}

export default CreateSubject;