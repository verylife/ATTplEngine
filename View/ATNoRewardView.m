//
//  ATNoRewardView.m
//  多拍相机
//
//  Created by Verylife on 14-8-6.
//  Copyright (c) 2014年 Verylife. All rights reserved.
//

#import "ATNoRewardView.h"

@implementation ATNoRewardView

- (id)initWithFrame:(CGRect)frame
{
	self = [super initWithFrame:frame];
	if (self) {
		[self addSubview:self.giftImageView];
		[self addSubview:self.rewardLabel];
		[self addSubview:self.inviteButton];
	}
	return self;
}

-(UIImageView *)giftImageView
{
	_giftImageView = [[UIImageView alloc] initWithFrame:CGRectMake(115,64,91.5,91.5)];
	_giftImageView.image = [UIImage imageNamed:@"reward_gift_none.png"];
	return _giftImageView;
}

-(RTLabel *)rewardLabel
{
	_rewardLabel = [[RTLabel alloc] initWithFrame:CGRectMake(0,189.5,320,100)];
	_rewardLabel.textAlignment = RTTextAlignmentCenter;
	_rewardLabel.text = @"不会吧，你没有任何奖励？邀请好友，让空间猛增到100G";
	return _rewardLabel;
}

-(UIButton *)inviteButton
{
	_inviteButton = [[UIButton alloc] initWithFrame:CGRectMake(70,270,180,50)];
	_inviteButton.titleLabel.font = HEIZHONG_FONT(14);
	_inviteButton.titleLabel.textColor = HEXCOLOR(0xffffff);
	[_inviteButton setBackgroundImage:[UIImage imageNamed:@"reward_none_bn.png"] forState:UIControlStateNormal];
	return _inviteButton;
}

@end				
